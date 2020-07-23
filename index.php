<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *, Authorization");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Credentials: true");

    require_once ('./components/Router.php');

    $router = new Router();
    $router->run();
?>
