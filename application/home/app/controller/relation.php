<?php

namespace home\app\controller;

use queryyetsimple\mvc\controller;
use common\domain\entity\hasone_user;
use common\domain\entity\hasone_idcard;
use common\domain\entity\hasmany_comment;

class relation extends controller {

    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        $oUser = hasone_user::find(1);


        print_r($oUser->idcard);
 

        echo '123456';

    }

   /**
     * 默认方法
     *
     * @return void
     */
    public function belongsTo() {
        $oIdCart = hasone_idcard::find('513023199001871455');
        var_dump($oIdCart->user);
 

        echo '123456';

    }

    /**
     * 默认方法
     *
     * @return void
     */
    public function belongsToSave() {
        $oIdCart = hasone_idcard::find('513023199001871455');
        var_dump($oIdCart->user()->getSourceValue());
 

        echo '123456';

    }

       /**
     * 默认方法
     *
     * @return void
     */
    public function belongsTo2() {
        $oIdCart = hasone_idcard::with('user')->getAll();


        foreach($oIdCart as $oi){
         
            print_r($oi->user->name);
        }


 

        echo '123456';

    }


         /**
     * 默认方法
     *
     * @return void
     */
    public function belongsTo3() {
        $oIdCart = hasone_idcard::with(['user.idcard'])->getAll();

        foreach($oIdCart as $oi){
      
          print_r($oi->user->idcard->idcard_address) ;
          //  exit();
        }

        
 

        echo '123456';

    }

             /**
     * 默认方法
     *
     * @return void
     */
    public function belongsTo4() {
        $oIdCart = hasone_idcard::with(['user.comment'])->getAll();

        foreach($oIdCart as $oi){
      
          print_r($oi->user->comment) ;
          //  exit();
        }

        
 

        echo '123456';

    }

       /**
     * 默认方法
     *
     * @return void
     */
    public function hasMany() {
        $oUser = hasone_user::find(1);


        var_dump($oUser->comment);
 

        echo '123456';

    }
       /**
     * 默认方法
     *
     * @return void
     */
    public function hasManySave() {
        $oUser = hasone_user::find(1);

        $comment = new hasmany_comment(['comment' => '一条新的评论。']);

        print_r($oUser->comment()->save($comment));
 

        $oUser->comment()->saveMany([
            new hasmany_comment(['comment' => '一条新的评论。']),
            new hasmany_comment(['comment' => '另一条评论。']),
        ]);

        $comment = $oUser->comment()->create([
            'comment' => '一条新的评论333。',
        ]);

        $oUser->comment()->createMany([
            [
                'comment' => '一条新的评论22222222。',
            ],
            [
                'comment' => '另一条新的评论2222222。',
            ],
        ]);

        $oUser->comment()->update([
            'hello' => 'xxxxxx'
        ]);

        echo '123456';

    }

       /**
     * 默认方法
     *
     * @return void
     */
    public function hasManyBelongsTo() {
        $arrComment = hasmany_comment::getAll();


        foreach($arrComment as $comment){
            echo $comment->user->name;
        }

        echo '123456';

    }

           /**
     * 默认方法
     *
     * @return void
     */
    public function manymany() {
        $oUser = hasone_user::find(1);


        print_r($oUser->role);
 

        echo '123456';

    }

               /**
     * 默认方法
     *
     * @return void
     */
    public function manymany2() {
        $oUser = hasone_user::with('role')->getAll();

        print_r($oUser);


       // foreach($oUser as $o){
            //print_r($o->role);
       // }
       
        echo '123456';

    }

    public function manyManySelect(){

        $oUser = hasone_user::find(1);



        print_r($oUser->role()->where('id',4)->getOne());
 

    }



        /**
     * 默认方法
     *
     * @return void
     */
    public function index2() {
        $arrUser = hasone_user::foobar()->with('idcard')->getAll();

        foreach($arrUser as $oUser){
            print_r($oUser->idcard->idcard_address);
        }

        echo '123456';

    }


    
}
