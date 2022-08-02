<?php

use app\controller\http\CollectionRoutes;

session_start();

header('Content-Type: application/json');

require_once '../../../vendor/autoload.php';

if (isset($_POST['route'])) {
    $post = $_POST;
    if (isset($_FILES)) {
        $post = array_merge($_POST, $_FILES);
    }

    $controller = new CollectionRoutes();
    echo $controller->run($post, $_POST['route']);
} else {
    http_response_code(400);
    echo json_encode("Rota não encontrada");
}