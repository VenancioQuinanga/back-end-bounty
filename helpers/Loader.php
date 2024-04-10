<?php

class Loader{
    public function load($args){
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: Get,,Post,Delete');
        header("Access-Control-Allow-Headers: Origin,X-Rquested-With,Content-Type,Accept,Authorization");
        header('Content-Type: Application/JSON');

        $a = $args;
        echo json_encode($a);

        /** 
        * @return 
        */
    }
}
