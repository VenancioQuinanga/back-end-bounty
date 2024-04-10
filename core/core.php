<?php

class core {
    public function run($routes){
        $url = '/';

        isset($_GET['url'])? $url .= $_GET['url'] : '';
        ($url != '/') ? $url = rtrim($url,'/') : $url;

        $routerFound = false;
        foreach ($routes as $path => $controller) {
            $pattern = '#^' .preg_replace('/{id}/' , '(\w+)' ,$path ).'$#';

            if (preg_match($pattern,$url,$matches)) {
                array_shift($matches);

                $routerFound = true;

                [$correntController,$action] = explode('@',$controller);

                require __DIR__ ."/../controllers/$correntController.php";

                $newController = new $correntController();
                $newController->$action();
                
            }
        }

        if (!$routerFound) {
            require __DIR__ ."/../controllers/NotFoundController.php";
            $controller = new NotFoundController();
            $controller->index();
        }
        
    }
}