<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Entity\Product\BaseBrandModel;
use Common\Helper\Prepare\Collaborator;
use Common\Model\LogBrandSynRecvModel;
use Common\Service\GoodsCollaboratorCheckService;

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

        $hello = [
            'x'    => 'y',

            'xx' => 'xx234234222',
        ];

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
     */
    public function saveEditBrand(): void
    {
        $brandIds = $this->getAgencyBrandIds();
        if (\in_array($this->in['brand_id'], $brandIds, true)) {
            $arrIn['return']['status'] = 'fail';
            $arrIn['return']['message'] = '分销商品品牌不能编辑';
            $this->ajaxReturn($arrIn['return']);
        }

        $this->saveAddBrand();
    }

    /**
     * 公司商品品牌添加保存.
     */
    public function saveAddBrand(): void
    {
        $objBrand = D('BaseBrand');
        $arrIn = ['return' => []];

        // 保存品牌
        if (IS_POST) {
            if ($objBrand->getBrandNum() === $this->in['brand_num']) {
                get_data_number('base_brand', 1);
            }

            if (($rstBrandID = $objBrand->updateInfo()) !== false) {
                $arrIn['return']['status'] = 'success';
                $arrIn['return']['bid'] = $rstBrandID;
                $arrIn['return']['letter'] = strtoupper(build_py_first($this->in['brand_name']));
                if (empty($this->in['brand_id'])) {
                    $arrIn['return']['new_brand_num'] = get_data_number('base_brand', 1);
                } else {
                    // 编辑品牌的时候，同步到运营商Alex 2017-01-09  start
                    if (is_company_ver()) {
                        $checkService = new GoodsCollaboratorCheckService();
                        $i = $checkService->updateBrandSet(get_company_id());
                        if ('error' === $i['status']) {
                            $arrIn['return']['status'] = 'fail';
                            $arrIn['return']['message'] = $i['message'];
                        }
                    }
                    // 编辑品牌的时候，同步到运营商Alex 2017-01-09  end
                }
                cache('goodsbrand[company]', 'delete');

                $arrIn['return']['message'] = L('is_success_jump');
            } else {
                $arrIn['return']['status'] = 'fail';
                $arrIn['return']['message'] = $objBrand->getError() ?: L('is_fail');
            }

            // 集团版本 供货端 修改商品需要同步数据到下游分销商
            // 2018/8/29
            if ('success' === $arrIn['return']['status'] && is_group_ver()) {
                $type = $this->in['brand_id'] ? 'update' : 'add';
                $syncBrand = new LogBrandSynRecvModel();
                send_group_ali_msg($syncBrand, 'brand', $type, [$arrIn['return']['bid']]);
            }

            $this->ajaxReturn($arrIn['return']);
        } else {
            $arrIn['return']['status'] = 'fail';
            $arrIn['return']['message'] = L('is_error');
            $this->ajaxReturn($arrIn['return']);
        }
    }

    /**
     * 删除公司商品品牌.
     */
    public function delBrand(): void
    {
        $objGoods = D('BaseGoods');
        $objBrand = D('BaseBrand');
        $arrIn = ['return' => []];

        if (empty($this->in['id'])) {
            $this->ajaxReturn(['status' => 'fail', 'message' => L('is_error')]);
        } else {
            // 2018/9/4 xiaochuan
            $brandIds = $this->getAgencyBrandIds();
            if (\in_array($this->in['id'], $brandIds, true)) {
                $arrIn['return']['status'] = 'fail';
                $arrIn['return']['message'] = '分销商品品牌不能删除';
                $this->ajaxReturn($arrIn['return']);
            }

            /*
             * 判断 目标品牌 是否已使用，如果已使用，则不能删除
             *   2016/01/22 by zjb
             */
            $map['brand_id'] = $this->in['id'];
            $objGoodsCount = $objGoods->getListCount(
                [
                    'map' => $map,
                ]
            );

            if ($objGoodsCount > 0) {
                $arrIn['return']['status'] = 'fail';
                $arrIn['return']['message'] = '该品牌已被使用，无法删除！';
                $this->ajaxReturn($arrIn['return']);
            }

            $config = get_app_config_by_name('HomePageSetting');
            if (!empty($config)) {
                if (\in_array($this->in['id'], $config['brand_select'], true)) {
                    $this->ajaxReturn(['status' => 'fail', 'message' => '自定义app首页中的品牌不能删除']);
                }
            }
        }

        if ($objBrand->delInfo(['brand_id' => (int) $this->in['id']])) {
            $arrIn['return']['status'] = 'success';
            $arrIn['return']['message'] = L('is_success_jump');
            // 编辑品牌的时候，同步到运营商Alex 2017-01-09  start
            if (is_company_ver()) {
                $checkService = new GoodsCollaboratorCheckService();
                $i = $checkService->updateBrandSet(get_company_id());
                if ('error' === $i['status']) {
                    $arrIn['return']['status'] = 'fail';
                    $arrIn['return']['message'] = $i['message'];
                }
            }
            // 编辑品牌的时候，同步到运营商Alex 2017-01-09  end
            cache('goodsbrand[company]', 'delete');
        } else {
            $arrIn['return']['status'] = 'fail';
            $arrIn['return']['message'] = $objBrand->getError() ?: L('is_fail');
        }

        $this->ajaxReturn($arrIn['return']);
    }

    public function getBrandsForSelectComponent(): void
    {
        $companyId = get_company_id();
        $brandData = D('BaseBrand')
            ->field('brand_id,brand_name,brand_letter,collaborator_id')
            ->where([
                'company_id' => $companyId,
                'status' => BaseBrandModel::STATUS_T,
            ])
            ->select()
        ;
        foreach ($brandData as $key => &$item) {
            $item['brand_letter'] = mb_substr($item['brand_letter'], 0, 1);
        }
        if (empty($brandData)) {
            $brandData = [];
        }

        // 只有联营版才需要查询联营相关信息
        if ($brandData && is_collaborate_ver()) {
            $collaboratorId = array_filter(array_column($brandData, 'collaborator_id'));
            if ($collaboratorId) {
                Collaborator::handle($brandData, null, ['field' => 'collaborator_id']);
            }
        } else {
            foreach ($brandData as &$brand) {
                $brand['collaborator_id'] = '0';
            }
        }

        $this->ajaxReturn($brandData);
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

    private function getAgencyBrandIds()
    {
        $synBrand = new LogBrandSynRecvModel();

        return $synBrand->where(['company_id' => get_company_id()])->getField('brand_id', true);
    }
}
