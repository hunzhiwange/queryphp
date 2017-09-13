<?php
namespace home\domain\model;

use queryyetsimple\mvc\model;

// console_template.file_comment
/**
 * 
 *
 * @author your.name<your.email>
 * @package $$
 * @since 2017.06.22
 * @version 1.0
 */
class  test extends model {

    //protected $strTable = 'xx';
    //
    //
    protected $mixConnect ='';
    ///protected $mixConnect = 'data2';
    //protected $mixConnect = 'data3';
    /**
     * 数据类型
     * 
     * @var array
     */
    protected $arrConversion = [
        'hello_world'    =>  'object',
        //'create_date' =>'datetime'
    ]; 

    protected $arrAutoFill = [
        //'hello_world'
    ];

    /**
     * 转换隐藏的属性
     *
     * @var array
     */
    protected $arrHidden = [ 

       // 'value','name'
    ];

   // const DELETED_AT = 'deleted2_at';

    /**
     * 转换显示的属性
     *
     * @var array
     */
    protected $arrVisible = [ 
        //'value','num','id','create_date'
    ];

    /**
     * 转换显示的属性
     *
     * @var array
     */
    protected $arrAppend = [ 
        //'hello','world'
    ];

     protected $arrDate = [ 
       // 'delete_at'
    ];

    /**
     * 设定用户的名字。
     *
     * @param  string  $value
     * @return void
     */
    //public function setHelloWorldAttribute($value, $name)
    //{
        //var_dump($value);
        //echo 's';
        //echo $value;
        //print_r($value);
        //$this->attributes['first_name'] = strtolower($value);
        //
        //$this->arrTempProp[$name] = $value.'xxxxxxxxxxx';

        //$this->changePropForce($name,$value.'xxxxxxxxxxx');
        //var_dump($value);
       // $this->arrProp[$name] = $value.'xxxxxxxxxxx';
    //}

   /**
     * 设定用户的名字。
     *
     * @param  string  $value
     * @return void
     */
    public function getNameProp($value)
    {
        return $value.'xxxxxxxxxxx';
    }


    protected function setAndReturnSerializePropStrTable($xx){
        //print_r($xx);
        //echo 'sdfffffffffffff';
        return $xx;
    }

    protected function setSerializeFilterProp($xxx){
       // print_r($xxx);
    }

    public function getHelloProp($value){
        return '我是你二大爷';
    }

    public function scopeThinkphp($query)
    {
        $query->where('id', '>' , 1)->setColumns('id,name');
//print_r( func_get_args() );

        //exit();
    }
    
    public function scopeAge($query)
    {
        $query->where('id','>',20)->limit(6);
    }    
    
    
}