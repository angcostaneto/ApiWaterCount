<?php

require '../vendor/autoload.php';
require '../utils/utils.php';

use App\Config\DB;
use App\Controller\LoginController;
use App\Model\UserModel;
use App\Model\TokenModel;
use App\Model\WaterCountModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = new DB();
    $user = new UserModel($db->getConnect());
    $token = new TokenModel($db->getConnect());
    $water = new WaterCountModel($db->getConnect());

    $login = new LoginController($user, $token, $water);

    verifyExistsToken();
    verifyIfTokenIsValid();

    $headers = apache_request_headers();

    // Make logout.
    $login = $login->logout($headers['Authorization']);

    if (!$login) {
        http_response_code(404);
        echo json_encode(['error' => 'Token invalid']);
    }
    else {
        echo json_encode(['success' => 'Logout with success']);
    }
}
else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not allowed']);
}