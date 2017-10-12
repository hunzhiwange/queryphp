<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;

// Verb    Path                        Action  Route Name
// GET     /users                      index   users.index
// GET     /users/create               create  users.create
// POST    /users                      store   users.store
// GET     /users/{user}               show    users.show
// GET     /users/{user}/edit          edit    users.edit
// PUT     /users/{user}               update  users.update
// DELETE  /users/{user}               destroy users.destroy


class cars extends controller {
    

    // /GET /cars
   public function index(){
        echo 'index';
    }
    
    // /GET /cars/create
    public function create(){
        echo 'create';
    } 

    // POST    /cars
    public function store(){
        echo 'post';
    }    


    // GET    /cars/22
    public function show(){
        echo 'show';
    }

    // GET    /cars/22/edit
    public function edit(){
        echo 'edit';
    }    
    
    // PUT /cars/22
    public function update(){
        echo 'update';
    }   

// DELETE /cars/22
      public function destroy(){
        echo 'delete';
    }    
}
