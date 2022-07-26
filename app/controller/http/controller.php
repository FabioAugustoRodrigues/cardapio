<?php

use app\controller\http\CollectionRoutes;

session_start();

header('Content-Type: application/json');

require_once '../../../vendor/autoload.php';

if (isset($_POST['route'])){
    $controller = new CollectionRoutes();
    echo $controller->run($_POST, $_POST['route']);
}else{
    http_response_code(400);
    echo json_encode("Route not informed");
}