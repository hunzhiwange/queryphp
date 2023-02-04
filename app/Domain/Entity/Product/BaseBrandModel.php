<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use App\Infra\Model;
use Exception;
use Leevel\Encryption\Helper\Text;
use Leevel\Support\Str\RandAlpha;

/**
 * 商品品牌模型
 */
class BaseBrandModel extends Model
{
    /**
     * 模型对应的实体.
     */
    public const ENTITY = BaseBrand::class;

    /**
     * 品牌状态 - 启用.
     */
    public const STATUS_T = 'T';

    /**
     * 品牌状态 - 禁用.
     */
    public const STATUS_F = 'F';

    protected array $_scope = array(
        // 命名范围normal
        'normal' => array(
            'where' => array('status' => 'T'),
        ),
        // 命名范围latest
        'latest' => array(
            'order' => 'create_date DESC',
            'limit' => 10,
        ),
        // 默认的命名范围
        'default' => array(
            'where' => array('brand_logo' => 'yes'),
            'limit' => 20,
        ),
        'list' => array(
            'where' => array('status' => 'T'),
            'order' => 'order_num DESC, brand_id ASC',
        ),
        'one' => array(
            'where' => array('status' => 'T'),
        ),
    );

    protected array $_auto = array(
        array(
            'company_id',
            'get_company_id',
            self::MODEL_INSERT,
            'function'
        ),
    );

    protected array $_validate = array(
        array(
            'brand_name',
            'checkName',
            '该商品品牌名称已存在,请重新输入!',
            self::VALUE_VALIDATE,
            'callback',
            self::MODEL_BOTH
        ),
        array(
            'brand_num',
            'checkNum',
            '商品品牌编号已存在,请重新输入!',
            self::VALUE_VALIDATE,
            'callback',
            self::MODEL_BOTH
        ),
        array(
            'seo_keywords',
            'email',
            'Email格式错误',
            self::VALUE_VALIDATE,
        ),
        array(
            'brand_letter',
            'url',
            'URL 格式错误',
            self::VALUE_VALIDATE,
        ),
    );

    /**
     * 获取商品品牌列表.
     */
    public function getList(array $arrIn = []): array
    {
        $arrIn['scope'] = 'list';

        return $this->findListAndCount($arrIn);
    }

    /**
     * 添加更新商品品牌信息.
     */
    public function updateInfo(array $arrIn): int
    {
        $this->create($arrIn);
        $arrData = $this->data();

        if (empty($arrData['brand_id'])) {
            // 验证编码重复问题
            $obj = new self();
            $arrIn2 = array();
            $arrIn2['map']['company_id'] = get_company_id();
            if (empty($arrData['brand_num'])) {
                $this->brand_num = RandAlpha::handle(10);
            } else {
                //验证编号是否重复
                $arrIn2['map']['brand_num'] = $arrData['brand_num'];
                $arrIn2['map']['status'] = 'T';
                $count = $obj->where($arrIn2['map'])->count();
                $this->brand_num = $count > 0 ? RandAlpha::handle(10) : $arrData['brand_num'];
            }
            $this->company_id = get_company_id();
            $this->brand_letter = strtoupper(RandAlpha::handle(5));
            $intID = $this->add();
        } else {
            $intID = $arrData['brand_id'];
            $brand_name = $arrData['brand_name'];
            if (!empty($brand_name)) {
                $arrData['brand_letter'] = strtoupper(RandAlpha::handle(5));
            }
            $this->save($arrData);
        }

        return $intID;
    }

    /**
     * 获取商品品牌信息.
     */
    public function getInfo(array $arrIn): mixed
    {
        $arrIn['scope'] = 'one';

        return $this->findOne($arrIn);
    }

    /**
     * 删除一条记录.
     */
    public function delInfo(array $arrIn): void
    {
        $arrIn['company_id'] = get_company_id();
        $this->create($arrIn, self::MODEL_UPDATE);
        $arrData = $this->data();

        if (!$arrIn['brand_id']) {
            throw new Exception('品牌 ID 未指定');
        } else {
            $arrData['status'] = 'F';
            $this->save($arrData);
        }
    }

    public function delInfoReal(array $arrIn): void
    {
        $arrIn['company_id'] = get_company_id();
        $this->create($arrIn, self::MODEL_UPDATE);
        $arrData = $this->data();

        if (!$arrIn['brand_id']) {
            throw new Exception('品牌 ID 未指定');
        } else {
            $this
                ->where($arrIn)
                ->delete();
        }
    }

    /**
     * 获取商品品牌列表.
     */
    public function getListSelect(array $arrIn): array
    {
        $arrIn['scope'] = 'list';
        $this->mergeScopeWhere($arrIn);

        return $this->getField('brand_id,brand_name');
    }

    /**
     * 获取自动品牌编码.
     */
    public function getBrandNum(): string
    {
        $strNum = RandAlpha::handle(5);

        $obj = new self();

        $arrIn = array();
        $arrIn['map']['company_id'] = get_company_id();
        $arrIn['map']['brand_num'] = $strNum;
        $arrLast = $obj->where($arrIn['map'])->field('brand_id')->order('brand_id DESC')->find();
        if (!empty($arrLast['brand_id'])) {
            $strNum = RandAlpha::handle(5);
        }

        return $strNum;
    }

    public function defineError(): void
    {
        $this->error = 'customer error';
    }

    public function trans1(array $in): void
    {
        $this->transaction(function () use ($in) {
            $this->brand_name = $in['first'];
            $this->add();

            $this->brand_name = $in['second'];
            $this->add();
            throw new Exception('error');
        });
    }

    public function trans2(array $in): void
    {
        $this->brand_name = $in['first'];
        $this->add();

        $this->brand_name = $in['second'];
        $this->add();
        throw new Exception('error');
    }

    public function trans3(array $in): string
    {
        $this->brand_name = $in['first'];
        $this->add();

        $this->brand_name = $in['second'];
        $this->add();

        return 'yes';
    }

    /**
     * 检查商品品牌编号是否可用.
     */
    protected function checkNum(): bool
    {
        $arrIn = array('map' => array());
        $arrIn['map'] = array(
            'company_id' => get_company_id(),
            'brand_num' => http_request_value('brand_num', '', 'trim'),
            'status' => 'T'
        );

        if (http_request_value('brand_id', '', 'intval')) {
            $arrIn['map']['brand_id'] = array('neq', http_request_value('brand_id', '', 'intval'));
        }

        return $this->where($arrIn['map'])->count() == 0;
    }

    /**
     * 检查商品品牌名称是否可用.
     */
    protected function checkName(): bool
    {
        $arrIn = array('map' => array());

        $arrIn['map'] = array(
            'company_id' => get_company_id(),
            'brand_name' => http_request_value('brand_name', '', 'trim'),
            'status' => 'T',
        );

        if (http_request_value('brand_id', '', 'intval')) {
            $arrIn['map']['brand_id'] = array('neq', http_request_value('brand_id', '', 'intval'));
        }
        return $this->where($arrIn['map'])->count() < 1;
    }

    protected function _before_write(array &$data): void
    {
        isset($data['brand_name']) && $data['brand_name'] = Text::handle($data['brand_name']);
    }
}
