<?php
require __DIR__.'/core/core.php';
require __DIR__.'/router/routes.php';

spl_autoload_register(function($file){
    if (file_exists(__DIR__."/helpers/$file.php")) {
        require_once __DIR__."/helpers/$file.php";
    }else if (file_exists(__DIR__."/models/$file.php")) {
        require_once __DIR__."/models/$file.php";
        
    }
});

$core = new core();
$core->run($routes);

/** 

* @api
*/