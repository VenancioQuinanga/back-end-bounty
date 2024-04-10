<?php

class UserController extends Loader{

    public function show(){

        $user = new User();
        
        $this->load([
        'msg'=>'ok',
        'users'=>$user->fetch()
        ]);
    }

    public function sign_up(){
        $user = new User;
        $this->load([
        'msg'=>'ok',
        'post'=>$user->doSign_up()
        ]);
    }
    public function drop(){
        $user = new User;
        $this->load([
        'msg'=>'ok',
        'get'=>$user->delete()
        ]);
    }

}
