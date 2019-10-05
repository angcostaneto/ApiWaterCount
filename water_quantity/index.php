<?php

require '../vendor/autoload.php';
require '../utils/utils.php';

use App\Config\DB;
use App\Controller\WaterController;
use App\Model\UserModel;
use App\Model\TokenModel;
use App\Model\WaterCountModel;

$db = new DB();

$user = new UserModel($db->getConnect());
$water = new WaterCountModel($db->getConnect());
$token = new TokenModel($db->getConnect());
$waterController = new WaterController($user, $water);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $url = getUrlParameters($_SERVER['REQUEST_URI']);
    verifyExistsToken();

    // Get the quantity of water from a specific user
    verifyIfTokenIsValid();
    if (isset($url[2])) {
        echo json_encode($waterController->getWaterCount($url[2]));
        die;
    }
    else {
        echo json_encode(['error' => 'Error to get user history']);
    }
}
else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not allowed']);
    die;
}