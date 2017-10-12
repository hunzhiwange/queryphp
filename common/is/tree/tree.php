<?php
namespace common\is\tree;

use queryyetsimple\support\tree as support_tree;

class tree {
    
    protected $oTree;

    public function __construct(array $arrNode){
        $this->oTree = $this->createTree($arrNode);
    }

    public function forList(){
        return  $this->oTree->toArray( function($arrItem){
            return [
                'id' => $arrItem['value'],
                'label' => $arrItem['data'],
            ];
        });
    }

    public function forSelect($iParentId=null){
        $arrTree = $this->oTree->toArray( function($arrItem){
            return [
                'value' => $arrItem['value'],
                'label' => $arrItem['data'],
            ];
        });

        if($iParentId){
            $arrSelected = $this->oTree->getParents( $iParentId );
        }else{
            $arrSelected = [];
        }
    
        return ['list' => $arrTree,'selected' => $arrSelected];
    }

    public function getChildren($intId){
        return $this->oTree->getChildren($intId);
    }

    public function hasChildren($intId,array $arrCheckChildren=[], $booStrict=true){
        return $this->oTree->hasChildren($intId, $arrCheckChildren, $booStrict);
    }

    protected function createTree (array $arrNode){
        return  new support_tree( $arrNode );
    }

    /**
     * 缺省方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return mixed
     */
    public function __call($sMethod, $arrArgs) {
        return call_user_func_array ( [ 
                $this->oTree,
                $sMethod 
        ], $arrArgs );
    }
}
