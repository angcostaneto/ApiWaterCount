<?php

require '../vendor/autoload.php';

use App\Config\DB;
use App\Controller\LoginController;
use App\Model\UserModel;
use App\Model\TokenModel;
use App\Model\WaterCountModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = new DB();
    $user = new UserModel($db->getConnect());
    $token = new TokenModel($db->getConnect());
    $water = new WaterCountModel($db->getConnect());

    $login = new LoginController($user, $token, $water);

    $_POST = json_decode(file_get_contents('php://input'), true);

    // Make login
    $login = $login->makeLogin($_POST['email'], $_POST['password']);

    if (!$login) {
        http_response_code(404);
        echo json_encode(['error' => 'Login or Password is incorrect']);
    }
    else {
        echo json_encode($login);
    }
}
else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not allowed']);
}