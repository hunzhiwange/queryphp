<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use Queryyetsimple\Http\Request as BaseRequest;

function hello($xx,$y) {print_r(func_get_args());
    return $xx+$y;
}

use Queryyetsimple\Filesystem;
use Queryyetsimple\Cookie;
use Queryyetsimple\Session;

class request {
    
    public function test()
    { 
        // echo 'test';  

        // $request = app('request');

        // print_r($request->headers);
       
        // ddd($request->path());
 //Session::set('xxx','xxxxx');
        // exit();
       // session_start();
      //ddd(Session::flash('hello')) ;

        //Session::flash('flash', 'sddd');

        //ddd($request->requestUrl());
        //print_r($_SESSION);
        //ddd(app('url')->make('/new-{id}-{name}', ['id' => 5, 'name' => 'tom', 'arg1' => '5']));

        //ddd(app('url')->make('/new-{id}-{name}?hello={foo}', ['id' => 5, 'name' => 'tom', 'foo' => 'bar', 'arg1' => '5']));
        
        dump(app('request')->query->get('xxx\1'));
        
         //$r = app('response');

        //$rr = $r->make('request/test');

         //return $rr;
        
        //return app('view')->display();
    }   

    public function upload(){
        //ddd(app('url')->make());

        //echo "hello world";
        //
        //$data = ['a' => 'b', 'c' => 'd'];
        //
        //return '555';

        //return $data;

        //$api = new \Queryyetsimple\Http\ApiResponse();

        //$api->unprocessableEntity($data);
        sleep(1);
        //$api->send();
        //
        $r = app('response');

        $rr = $r->redirect('request/test')->withInput(['hello'=>'world'])->withErrors('hello','world')->with('hello','world');
        //
        //$rr = $r->viewSuccess('1111');

      //  ddd($rr)
      //  
        return $rr;

        //$rr->send();

        //return $rr;

        //ddd($_FILES);
        //echo "111";
       //$request = app('request');

       //dump(\Queryyetsimple\Http\Request::METHOD_HEAD);

       //dump($request->getEnter());
       //dump($request->query->get('cc|home\app\controller\hello=5222'));

       //ddd($request->file('my-form\details\\'));

        // Filesystem::put('hello.txt', 'sffffffffff');

        // ddd($request->files->get('myfile')->move('/mnt/hgfs/newphp/queryphp/storage'));
        //$response =  \Queryyetsimple\Http\RedirectResponse::create('http://baidu.com');
        //$response =  \Queryyetsimple\Http\JsonResponse::create(['http://baidu.com']);
        //ddd($response);
        //$response =  \Queryyetsimple\Http\FileResponse::create('/mnt/hgfs/newphp/queryphp/storage/hello.txt');
        //
        //$response->setCallback('helloworl');

        //$response->send();
        
        //Cookie::set('hello', 'world');
    }
}
