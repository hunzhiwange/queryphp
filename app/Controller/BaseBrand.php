<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Entity\Product\BaseBrandModel;

/**
 * 品牌控制器.
 */
class BaseBrand
{
    public function __construct()
    {
        $this->in = http_request()->all();
        container()->instance('company_id', 0);
    }

    /**
     * 商品品牌.
     *
     * @see http://127.0.0.1:9527/base_brand/index?page=1&size=3&brand_name=Northside
     */
    public function index(): array
    {
        $objBrand = BaseBrandModel::make();
        $arrIn = [];
        $this->page();
        if (!empty($this->in['kw'])) {
            $arrTpl['condition']['kw'] = $this->in['kw'];
            $arrIn['map']['_string'] = "(brand_name LIKE \"%{$arrTpl['condition']['kw']}%\" OR brand_letter LIKE \"%{$arrTpl['condition']['kw']}%\" OR brand_num LIKE \"%{$arrTpl['condition']['kw']}%\")";
        }
        if (!empty($this->in['brand_name'])) {
            $arrIn['map']['brand_name'] = $this->in['brand_name'];
        }
        $arrIn['field'] = 'brand_id,order_num,brand_num,brand_name,brand_letter';
        $arrIn['page'] = [$this->in['page'], $this->in['size']];

        return $objBrand->getList($arrIn);
    }

    /**
     * 公司商品品牌界面.
     *
     * @see http://127.0.0.1:9527/base_brand/add_brand
     */
    public function addBrand(): array
    {
        // 载入商品品牌的num
        $arrTpl = [];
        $arrTpl['brand_num'] = BaseBrandModel::make()->getBrandNum();

        return $arrTpl;
    }

    /**
     * 商品品牌编号唯一性验证.
     *
     * @see http://127.0.0.1:9527/base_brand/check_brand_num?brand_num=hello1
     */
    public function checkBrandNum(): array
    {
        if (!isset($this->in['brand_num'])) {
            return ['verify' => true];
        }

        $objBrand = BaseBrandModel::make();

        return ['verify' => $objBrand->checkNum()];
    }

    /**
     * 商品品牌名字唯一性验证.
     *
     * @see http://127.0.0.1:9527/base_brand/check_brand_name?brand_name=hello1
     */
    public function checkBrandName()
    {
        if (!isset($this->in['brand_name'])) {
            return ['verify' => true];
        }

        $objBrand = BaseBrandModel::make();

        return ['verify' => $objBrand->checkName()];
    }

    /**
     * 快捷添加商品品牌名.
     */
    public function addBrandName(): void
    {
        $brand_name = trim($this->in['brand_name']) ?: $this->apiJsonReturn('', 'fail', '参数错误!');
        $brand_num = get_data_number('base_brand', 1);
        $brand_letter = strtoupper(build_py_first($this->in['brand_name']));
        $company_id = get_company_id();
        // 实例化模型
        $base_brand_model = D('BaseBrand');
        // 检查品牌名|品牌编号是否重复
        $is_exist = $base_brand_model
            ->where(['company_id' => $company_id, 'brand_name' => $brand_name, 'status' => 'T'])
            ->count(1)
        ;
        if ($is_exist > 0) {
            $this->apiJsonReturn('', 'fail', '品牌名称已存在!');
        }
        // 添加到数据库
        $base_brand_add_res = $base_brand_model
            ->add(['company_id' => $company_id, 'brand_name' => $brand_name, 'brand_num' => $brand_num, 'brand_letter' => $brand_letter])
        ;
        cache('goodsbrand[company]', 'delete');
        if (false === $base_brand_add_res) {
            $this->apiJsonReturn('', 'fail', '添加失败!');
        }
        $this->apiJsonReturn();
    }

    /**
     * 编辑公司商品品牌.
     */
    public function editBrand(): void
    {
        if (!empty($this->in['ajax'])) {
            switch ($this->in['ajax']) {
                case 'checkBrandnum':
                    $this->_checkBrandnum();

                    break;

                case 'checkBrandname':
                    $this->_checkBrandname();

                    break;

                default:
                    exit('错误参数');

                    break;
            }

            exit;
        }

        $objBrand = D('BaseBrand');
        $arrTpl = ['info' => []];

        if (empty($this->in['id'])) {
            exit('');
        }

        $arrIn['map'] = ['brand_id' => (int) $this->in['id']];
        $arrTpl['info'] = $objBrand->getInfo($arrIn);
        if ($arrTpl['info']) {
            if ($arrTpl['info']['collaborator_id']) {
                $this->errorMessage('不能编辑联营商品牌', 'BaseBrand/index');
            }
            $this->assign($arrTpl);
            $this->display('dialog+addBrand');
        } else {
            exit('');
        }
    }

    /**
     * 公司商品品牌更新保存.
     *
     * @see http://127.0.0.1:9527/base_brand/save_edit_brand?brand_id=1&brand_name=hello2&brand_logo=world&_ajax=1
     */
    public function saveEditBrand(): array
    {
        if (empty($this->in['brand_id'])) {
            throw new \Exception('品牌 ID 未设置');
        }
        // 保存品牌
        $objBrand = BaseBrandModel::make();
        $objBrand->updateInfo($this->in);

        return [];
    }

    /**
     * 公司商品品牌添加保存.
     *
     * @see http://127.0.0.1:9527/base_brand/save_add_brand?brand_name=hello&brand_logo=world&_ajax=1
     */
    public function saveAddBrand(): array
    {
        if (!empty($this->in['brand_id'])) {
            throw new \Exception('新增品牌不能传品牌 ID');
        }
        // 保存品牌
        $objBrand = BaseBrandModel::make();
        $rstBrandID = $objBrand->updateInfo($this->in);

        return ['bid' => $rstBrandID];
    }

    /**
     * 删除公司商品品牌.
     *
     * @see http://127.0.0.1:9527/base_brand/del_brand?id=1
     */
    public function delBrand(): array
    {
        $objBrand = BaseBrandModel::make();

        if (empty($this->in['id'])) {
            throw new \InvalidArgumentException('品牌 ID 不能为空');
        }

        $objBrand->delInfo(['brand_id' => (int) $this->in['id']]);

        return [];
    }

    /**
     * @see http://127.0.0.1:9527/base_brand/get_brands_for_select_component
     */
    public function getBrandsForSelectComponent(): array
    {
        $companyId = get_company_id();
        $brandData = BaseBrandModel::make()
            ->field('brand_id,brand_name,brand_letter')
            ->where([
                'company_id' => $companyId,
                'status' => BaseBrandModel::STATUS_T,
            ])
            ->select()
        ;
        foreach ($brandData as &$item) {
            $item['brand_letter'] = mb_substr($item['brand_letter'], 0, 1);
        }
        unset($item);

        return $brandData;
    }

    /**
     * 分页参数分析.
     */
    protected function page(int $maxPageSize = 30): void
    {
        $this->in['page'] = abs((int) ($this->in['page'] ?? 1));
        $this->in['size'] = abs((int) ($this->in['size'] ?? 30));
        if ($this->in['size'] > $maxPageSize) {
            $this->in['size'] = $maxPageSize;
        }
    }
}
