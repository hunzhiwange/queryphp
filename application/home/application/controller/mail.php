<?php

namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\mail;

class index extends controller {

    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        //$name = 'hello';
        // $flag = mail::send('mail_test',['name'=>$name],function($message){
        //     $to = 'lxm@rsung.com';
        //     $message ->to($to)->subject('测试邮件22222222');
        //     echo 'hello world';
        // });

       // var_dump($flag);
        
        $obj = mail::foobar()

        ->view('mail_test',['img'=>file_get_contents('D:/lxm/php/logo.png'),'img2'=>'D:/lxm/php/logo.png'])

       // ->view('mail_test')

       // ->viewPlain('mail_testw')

       // ->viewPlain('mail_testw')

        //->plain('plain')
       // ->html('<h2>html<img src="https://www.baidu.com/img/qixi_pc_f35fe4b00cc1d200aea7cf9f86ae5dae.gif"/></h2>')

        //->attach('D:/lxm/php/logo.png',function($oAttachenent,$oStore){
          //  $oAttachenent->setFilename($oStore->attachChinese('中国人.jpg'));
       // })

        ->message(function($oMessage){
            $oMessage
                ->setSubject('测试邮件')
                ->setTo(['635750556@qq.com' =>'小牛仔']);
        })

        ->send();

        $flag = 1;
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }


        $this->display ();
    }
    
    public function show(){
    }

    public function yes(request $xx,$what){
    }

}
