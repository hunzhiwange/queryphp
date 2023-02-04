<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Entity\Product\BaseBrand;
use App\Infra\Model;
use Leevel\Encryption\Helper\Text;

/**
 * 商品品牌模型
 */
class BaseBrandModel extends Model {

    const ENTITY = BaseBrand::class;

    /** @var string 品牌状态 - 启用 */
    public const STATUS_T = 'T';

    /** @var string 品牌状态 - 禁用 */
    public const STATUS_F = 'F';

    protected array $_scope = array(
        // 命名范围normal
        'normal'=>array(
            'where'=>array('status'=>'T'),
        ),
        // 命名范围latest
        'latest'=>array(
            'order'=>'create_date DESC',
            'limit'=>10,
        ),
        // 默认的命名范围
        'default'=>array(
            'where'=>array('brand_logo'=>'yes'),
            'limit'=>20,
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
        )
    );

    /**
     * 检查商品品牌编号是否可用.
     * @return bool
     */
    public function checkNum(){
        $arrIn = array('map' => array());
        $arrIn['map'] = array(
            'company_id' => get_company_id(),
            'brand_num' => http_request_value('brand_num','','trim'),
            'status'=>'T'
        );
        
        if(http_request_value('brand_id','','intval')){
            $arrIn['map']['brand_id'] = array('neq',http_request_value('brand_id','','intval'));
        }

        return $this->where($arrIn['map'])->count() == 0;
    }
    
    /**
     * 检查商品品牌名称是否可用
     * @return bool
     */
    public function checkName(){
        $arrIn = array('map' => array());

        $arrIn['map'] = array(
            'company_id' 	=> get_company_id(),
            'brand_name' => http_request_value('brand_name','','trim'),
            'status' => 'T',
            'collaborator_id' => 0 //运营商校验数据时，排除同名的联营商品牌
        );
    
        if(http_request_value('brand_id','','intval')){
            $arrIn['map']['brand_id'] = array('neq',http_request_value('brand_id','','intval'));
        }
        return $this->where($arrIn['map'])->count() < 1;
    }
    
    /**
     * 获取商品品牌列表
     * @param array $arrIn 手动传入的数据
     * @return array 商品品牌信息
     */
    public function getList($arrIn = array()) {
        $arrIn = array_merge(array('field' => true, 'map' => array(), 'order' => 'order_num DESC, brand_id ASC', 'limit' => ''), $arrIn);
        if(!isset($arrIn['map']['status'])) {
            $arrIn['map']['status'] = 'T';
        }
        
        if(empty($arrIn['map']['company_id'])) {
            $arrIn['map']['company_id'] = get_company_id();
        }
        
        $arrData['count'] = $this->where($arrIn['map'])->count();
        $arrData['list'] = $this->where($arrIn['map'])
                                ->field($arrIn['field'])
                                ->order($arrIn['order'])
                                ->limit($arrIn['limit'])
                                ->select();
                            
        return $arrData;
    }

    /**
     * 添加更新商品品牌信息
     * @paray array $arrIn 手动传入的数据
     * @return boolean fasle 失败 成功返回ID
     */
    public function updateInfo($arrIn = array()) {

        $arrData = $this->create($arrIn);

        if(empty($arrData)) {
            return false;
        }
        if(empty($arrData['brand_id'])) {
            // 验证编码重复问题
            $obj = new self();
            $arrIn2 = array();
            $arrIn2['map']['company_id'] = get_company_id();
            if(empty($arrData['brand_num'])){
                $this->brand_num=get_data_number('base_brand', 1);
            }else{
                //验证编号是否重复
                $arrIn2['map']['brand_num']=$arrData['brand_num'];
                $arrIn2['map']['status']='T';
                $count = $obj->where($arrIn2['map'])->count();
                $this->brand_num=(($count>0)?get_data_number('base_brand', 1):$arrData['brand_num']);
            }
            $this->company_id = get_company_id();
            $this->brand_letter = strtoupper(build_py_first($arrData['brand_name']));
            $intID = $this->add();
            if(!$intID){
                $this->error = L('add_base_content');
                return false;
            }
        } else {
            $intID = $arrData['brand_id'];
            $brand_name = $arrData['brand_name'];
            if(!empty($brand_name)) {
                $arrData['brand_letter'] = strtoupper(build_py_first($brand_name));
            }
            if(false === $this->save($arrData)){
                $this->error = L('update_base_content');
                return false;
            }
        }
        
        return $intID;
    }
    
    /**
     * 获取商品品牌信息
     * @param array $arrIn 手动传入的数据
     * @return array 商品品牌信息
     */
    public function getInfo($arrIn = array()) {
        $arrIn = array_merge(array('field' => true, 'map' => array()), $arrIn);
        if(!isset($arrIn['map']['status'])) {
            $arrIn['map']['status'] = 'T';
        }
        $arrIn['map']['company_id'] = get_company_id();
        
        return $this->where($arrIn['map'])->field($arrIn['field'])->find();
    }
    
    /**
     * 删除一条记录
     * @param array $arrIn 手动传入的数据 brand_id：商品品牌ID
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     */
    public function delInfo($arrIn = array()) {
        $arrIn['company_id'] = get_company_id();
        $arrData = $this->create($arrIn, 2);
        if(empty($arrData)) {
            return false;
        }
        
        if(!$arrIn['brand_id']) { 
            $this->error = L('is_error');
            return false;
        } else { 
            $arrData['status'] = 'F';
            if(false === $this->save($arrData)) {
                $this->error = L('update_base_content');
                return false;
            }
        }
        
        return $arrIn['brand_id'];
    }
    
    /**
     * 获取商品品牌列表[搜索下拉条件]
     * @param array $arrIn 手动传入的数据
     * @return array 商品品牌信息
     */
    public function getListSelect($arrIn = array()) {
        $arrIn = array_merge(array('field_key' => 'brand_id', 'field_val' => 'brand_name', 'map' => array(), 'order' => 'order_num DESC,brand_id DESC'), $arrIn);
        if(!isset($arrIn['map']['status'])) {
            $arrIn['map']['status'] = 'T';
        }
        $arrIn['map']['company_id'] = get_company_id();
    
        return $this->where($arrIn['map'])->order($arrIn['order'])->getField($arrIn['field_key'].','.$arrIn['field_val']);
    }
    
    /**
     * 获取自动品牌编码
     * @return string 分类编码
     */
    public function getBrandNum() {
        $strNum = get_data_number('base_brand');

        $obj = new self();

        $arrIn = array();
        $arrIn['map']['company_id'] = get_company_id();
        $arrIn['map']['brand_num'] = $strNum;
        $arrLast = $obj->where($arrIn['map'])->field('brand_id')->order('brand_id DESC')->find();
        if(!empty($arrLast['brand_id'])) { 
            $strNum = get_data_number('base_brand', 1);
        }
        
        return $strNum;
    }

    public function defineError()
    {
        $this->error = 'customer error';
    }

    protected function _before_write(array &$data): void
    {
        isset($data['brand_name']) && $data['brand_name'] = Text::handle($data['brand_name']);
    }
}
