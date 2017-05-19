<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\mvc;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use ArrayAccess;

/**
 * 模型 orm
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.27
 * @version 1.0
 */
class model implements ArrayAccess {
    
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $strTable = '';
    
    /**
     * 此模型的连接名称
     *
     * @var mixed
     */
    protected $mixConnect = '';
    
    /**
     * 模型属性
     *
     * @var array
     */
    protected $arrProp = [ ];
    
    /**
     * 改变的模型属性
     *
     * @var array
     */
    protected $arrChangeProp = [ ];
    
    /**
     * 构造器初始化数据黑名单
     *
     * @var array
     */
    protected $arrConstructBlack = [ ];
    
    /**
     * 构造器初始化数据白名单
     *
     * @var array
     */
    protected $arrConstructWhite = [ ];
    
    /**
     * 写入数据黑名单
     *
     * @var array
     */
    protected $arrCreateBlack = [ ];
    
    /**
     * 写入数据白名单
     *
     * @var array
     */
    protected $arrCreateWhite = [ ];
    
    /**
     * 更新数据黑名单
     *
     * @var array
     */
    protected $arrUpdateBlack = [ ];
    
    /**
     * 更新数据白名单
     *
     * @var array
     */
    protected $arrUpdateWhite = [ ];
    
    /**
     * 只读属性
     *
     * @var array
     */
    protected $arrReadonly = [ ];
    
    /**
     * 是否自动提交 POST 数据
     *
     * @var boolean
     */
    protected $booAutoPost = true;
    protected $arrPostField = [ ];
    protected $arrAutofill = [ 
            'name',
            'ip' 
    ];
    protected $arrCreateAutofill = [ 
            'status' => 1 
    ];
    protected $arrUpdateAutofill = [ ];
    
    // protected $arrAllBlack=[];
    // protected $arrUpdateWhite=[];
    
    // post_map_field
    
    // protected $booIncrementing = false;
    
    // protected $arrTimestamps = false;
    // protected $_sClassName;
    // protected static $_arrMeta;
    // protected $_bAutofill=true;
    /**
     * 模型的日期字段保存格式。
     *
     * @var string
     */
    // protected $dateFormat = 'U';
    
    /**
     * 是否处于强制改变属性中
     *
     * @var boolean
     */
    private $booInChangePropForce = false;
    
    /**
     * 构造函数
     *
     * @param array|null $arrData            
     * @param string $strTable            
     * @param mixed $mixConnect            
     * @return void
     */
    public function __construct($arrData = null, $strTable = null, $mixConnect = null) {
        if (is_array ( $arrData ) && $arrData) {
            if ($this->arrConstructBlack) {
                foreach ( $arrData as $strField => $mixValue ) {
                    if (in_array ( $strField, $this->arrConstructBlack ) && ! in_array ( $strField, $this->arrConstructBlack )) {
                        unset ( $arrData [$strField] );
                    }
                }
            }
            if ($arrData) {
                $this->changeProp ( $arrData );
            }
        }
        
        if (! is_null ( $strTable )) {
            $this->strTable = $strTable;
        }
        
        if (! is_null ( $mixConnect )) {
            $this->mixConnect = $mixConnect;
        }
    }
    
    /**
     * 魔术方法获取
     *
     * @param string $sPropName            
     * @return mixed
     */
    public function __get($sPropName) {
        return $this->getProp ( $sPropName );
    }
    
    /**
     * 强制更新属性值
     *
     * @param string $sPropName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function __set($sPropName, $mixValue) {
        return $this->changePropForce ( $sPropName, $mixValue );
    }
    
    /**
     * 是否存在属性
     *
     * @param string $sPropName            
     * @return boolean
     */
    public function __isset($sPropName) {
        return $this->hasProp ( $sPropName );
    }
    
    /**
     * 实现 ArrayAccess::offsetExists
     *
     * @param string $sPropName            
     * @return boolean
     */
    public function offsetExists($sPropName) {
        return $this->hasProp ( $sPropName );
    }
    
    /**
     * 实现 ArrayAccess::offsetSet
     *
     * @param string $sPropName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function offsetSet($sPropName, $mixValue) {
        return $this->changePropForce ( $sPropName, $mixValue );
    }
    
    /**
     * 实现 ArrayAccess::offsetGet
     *
     * @param string $sPropName            
     * @return mixed
     */
    public function offsetGet($sPropName) {
        return $this->getProp ( $sPropName );
    }
    
    /**
     * 实现 ArrayAccess::offsetUnset
     *
     * @param string $sPropName            
     * @return mixed
     */
    public function offsetUnset($sPropName) {
        $this->deleteProp ( $sPropName );
    }
    
    /**
     * 保存统一入口
     *
     * @param string $sSaveMethod            
     * @param string $arrData            
     * @return $this
     */
    public function save($sSaveMethod = 'save', $arrData = null) {
        // 强制更新数据
        if (is_array ( $arrData ) && $arrData) {
            $this->changePropForce ( $arrData );
        }
        
        // 表单自动填充
        $this->autoPost_ ();
        
        // $this->beforeSave_();
        
        // 程序通过内置方法统一实现
        switch (strtolower ( $sSaveMethod )) {
            case 'create' :
                $this->create_ ();
                break;
            case 'update' :
                $this->update_ ();
                break;
            case 'replace' :
                $this->replace_ ();
                break;
            case 'save' :
            default :
                $arrPrimaryData = $this->primaryKey ( true );
                
                // 复合主键的情况下，则使用 replace 方式
                if (is_array ( $arrPrimaryData )) {
                    $this->replace_ ();
                }                 

                // 单一主键
                else {
                    if (empty ( $arrPrimaryData )) {
                        $this->create_ ();
                    } else {
                        $this->update_ ();
                    }
                }
                break;
        }
        
        // $this->afterSave_();
        return $this;
    }
    
    /**
     * 获取主键
     *
     * @param string $booUpdateChange            
     * @return NULL|array
     */
    public function primaryKey($booUpdateChange = false) {
        $arrPrimaryData = [ ];
        
        $arrPrimaryKey = $this->meta ()->getPrimaryKey ();
        foreach ( $arrPrimaryKey as $sPrimaryKey ) {
            if (! isset ( $this->arrProp [$sPrimaryKey] )) {
                continue;
            }
            if ($booUpdateChange === true) {
                if (! in_array ( $sPrimaryKey, $this->arrChangeProp )) {
                    $arrPrimaryData [$sPrimaryKey] = $this->arrProp [$sPrimaryKey];
                }
            } else {
                $arrPrimaryData [$sPrimaryKey] = $this->arrProp [$sPrimaryKey];
            }
        }
        
        // 复合主键，但是数据不完整则忽略
        if (count ( $arrPrimaryKey ) > 1 && count ( $arrPrimaryKey ) != count ( $arrPrimaryData )) {
            return null;
        }
        
        if (count ( $arrPrimaryData ) == 1) {
            $arrPrimaryData = reset ( $arrPrimaryData );
        }
        
        if (! empty ( $arrPrimaryData )) {
            return $arrPrimaryData;
        } else {
            return null;
        }
    }
    
    /**
     * 改变属性
     *
     * < update 调用无效，请换用 changePropForce >
     *
     * @param mixed $mixProp            
     * @param mixed $mixValue            
     * @return $this
     */
    public function changeProp($mixProp, $mixValue = null) {
        if (! is_array ( $mixProp )) {
            $mixProp = [ 
                    $mixProp => $mixValue 
            ];
        }
        
        $booInChangePropForce = $this->getInChangePropForce_ ();
        $mixProp = $this->meta ()->fieldsProps ( $mixProp );
        foreach ( $mixProp as $sName => $mixValue ) {
            $this->arrProp [$sName] = $mixValue;
            if ($booInChangePropForce === true && ! in_array ( $sName, $this->arrReadonly ) && ! in_array ( $sName, $this->arrChangeProp )) {
                $this->arrChangeProp [] = $sName;
            }
        }
        
        return $this;
    }
    
    /**
     * 强制改变属性
     *
     * @param mixed $mixPropName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function changePropForce($mixPropName, $mixValue = null) {
        $this->setInChangePropForce_ ( true );
        call_user_func_array ( [ 
                $this,
                'changeProp' 
        ], func_get_args () );
        $this->setInChangePropForce_ ( false );
        return $this;
    }
    
    /**
     * 返回属性
     *
     * @param string|null $mixPropName            
     * @return mixed
     */
    public function getProp($mixPropName = null) {
        if (is_null ( $mixPropName )) {
            return $this->arrProp;
        } else {
            return isset ( $this->arrProp [$mixPropName] ) ? $this->arrProp [$mixPropName] : null;
        }
    }
    
    /**
     * 是否存在属性
     *
     * @param string $sPropName            
     * @return boolean
     */
    public function hasProp($sPropName) {
        return array_key_exists ( $sPropName, $this->arrProp );
    }
    
    /**
     * 删除属性
     *
     * @param string $sPropName            
     * @return void
     */
    public function deleteProp($sPropName) {
        if (! isset ( $this->arrProp [$sPropName] )) {
            unset ( $this->arrProp [$sPropName] );
        }
    }
    
    /**
     * 返回改变
     *
     * @return array
     */
    public function getChanged() {
        return $this->arrChangedProp;
    }
    
    /**
     * 检测是否已经改变
     *
     * @param string $sPropsName            
     * @return boolean
     */
    public function hasChanged($sPropsName = null) {
        // null 判读是否存在属性
        if (is_null ( $sPropsName )) {
            return ! empty ( $this->arrChangedProp );
        }
        
        $arrPropsName = helper::arrays ( $sPropsName );
        foreach ( $arrPropsName as $sPropName ) {
            if (isset ( $this->arrChangedProp [$sPropName] ))
                return true;
        }
        return false;
    }
    
    /**
     * 清除改变属性
     *
     * @param mixed $mixProp            
     * @return array
     */
    public function clearChanged($mixProp = null) {
        if (is_null ( $mixProp )) {
            $this->arrChangedProp = [ ];
        } else {
            $mixProp = helper::arrays ( $mixProp );
            foreach ( $mixProp as $sProp ) {
                if (isset ( $this->arrChangedProp [$sProp] ))
                    unset ( $this->arrChangedProp [$sProp] );
            }
        }
    }
    
    /**
     * 是否自动提交表单数据
     *
     * @param boolean $booAutoPost            
     * @return void
     */
    public function autoPost($booAutoPost = true) {
        $this->booAutoPost = $booAutoPost;
    }
    
    /**
     * 返回模型类的 meta 对象
     *
     * @return Meta
     */
    public function meta() {
        if (! $this->strTable) {
            $strTable = get_called_class ();
            $strTable = explode ( '\\', $strTable );
            $this->strTable = array_pop ( $strTable );
        }
        return meta::instance ( $this->strTable, $this->mixConnect );
    }
    
    /**
     * 创建数据
     *
     * @return void
     */
    private function create_() {
        // $oMeta=static::$_arrMeta[$this->_sClassName];
        
        // // 自动填充
        // if($this->_bAutofill===true){
        // $this->autofill_('create');
        // }
        // foreach($oMeta->_arrTableMeta['default'] as $sPropName=>$defaultVal){
        // if(!isset($this->_arrProp[$sPropName]) || $this->_arrProp[$sPropName]===null){
        // $this->_arrProp[$sPropName]=$defaultVal;
        // }
        // }
        
        // $this->beforeCreate_();
        // if($this->check_('create',true)===false){// 进行create验证
        // return false;
        // }
        
        // 准备要保存到数据库的数据
        $arrSaveData = [ ];
        foreach ( $this->arrProp as $sPropName => $mixValue ) {
            if (is_null ( $mixValue )) {
                continue;
            }
            if (in_array ( $sPropName, $this->arrCreateBlack ) && ! in_array ( $sPropName, $this->arrCreateWhite )) {
                continue;
            }
            $arrSaveData [$sPropName] = $mixValue;
        }
        
        // 执行保存
        $arrLastInsertId = $this->meta ()->insert ( $arrSaveData );
        
        // LastInsertId 赋值
        foreach ( $arrLastInsertId as $sField => $mixValue ) {
            $this->arrProp [$sField] = $mixValue;
        }
        
        // $this->afterCreate_();
        
        // 清除所有属性改变
        $this->clearChanged ();
    }
    
    /**
     * 更新数据
     *
     * @return void
     */
    private function update_() {
        // $oMeta=static::$_arrMeta[$this->_sClassName];
        // if($this->_bAutofill===true){// 这里允许update和all
        // $this->autofill_('update');
        // }
        
        // $this->beforeUpdate_();
        // if($this->check_('update',true)===false){// 进行update验证
        // return false;
        // }
        $arrSaveData = [ ];
        foreach ( $this->arrProp as $sPropName => $mixValue ) {
            if (! in_array ( $sPropName, $this->arrChangeProp )) {
                continue;
            }
            if (in_array ( $sPropName, $this->arrUpdateBlack ) && ! in_array ( $sPropName, $this->arrUpdateWhite )) {
                continue;
            }
            $arrSaveData [$sPropName] = $mixValue;
        }
        
        // print_r($arrSaveData);
        //
        // exit();
        
        // $arrSaveData=$this->arrChangeProp;
        
        if (! empty ( $arrSaveData )) {
            $arrConditions = array ();
            foreach ( $this->meta ()->getPrimaryKey () as $sFieldName ) {
                if (isset ( $arrSaveData [$sFieldName] )) {
                    unset ( $arrSaveData [$sFieldName] );
                }
                if (! empty ( $this->arrProp [$sFieldName] )) {
                    $arrConditions [$sFieldName] = $this->arrProp [$sFieldName];
                }
            }
            // print_r($arrSaveData);
            // print_r($arrSaveData);
            if (! empty ( $arrSaveData ) && ! empty ( $arrConditions )) {
                print_r ( $this->meta ()->update ( $arrConditions, $arrSaveData ) );
                // database::table( 'test')
                // ->where('id',503)
                // ->update(['name' => '小猪'])
                
                // $bResult=$oMeta->_oTable->update($arrSaveData,$arrConditions);
                // if($bResult===false){
                // $this->_sErrorMessage=$oMeta->_oTable->getErrorMessage();
                // return false;
                // }
            }
        }
        
        // $this->afterUpdate_();
        
        // 清除所有属性改变
        $this->clearChanged ();
    }
    
    /**
     * 模拟 replace 数据
     *
     * @return void
     */
    private function replace_() {
        try {
            $this->create_ ();
        } catch ( \Exception $e ) {
            $this->update_ ();
        }
    }
    
    /**
     * 自动提交表单数据
     *
     * @return void
     */
    private function autoPost_() {
        if ($this->booAutoPost === false) {
            return;
        }
        
        if (empty ( $_POST )) {
            return;
        }
        
        $_POST = $this->meta ()->fieldsProps ( $_POST );
        foreach ( $_POST as $strField => $mixValue ) {
            if (! in_array ( $strField, $this->arrChangeProp )) {
                $this->arrProp [$strField] = trim ( $mixValue );
                $this->arrChangeProp [] = $strField;
            }
        }
    }
    
    /**
     * 设置是否处于强制更新属性的
     *
     * @return boolean
     */
    private function setInChangePropForce_($booInChangePropForce = true) {
        $this->booInChangePropForce = $booInChangePropForce;
    }
    
    /**
     * 返回是否处于强制更新属性的
     *
     * @return boolean
     */
    private function getInChangePropForce_() {
        return $this->booInChangePropForce;
    }
}
