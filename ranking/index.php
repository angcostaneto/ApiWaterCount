<?php

require '../vendor/autoload.php';
require '../utils/utils.php';

use App\Config\DB;
use App\Controller\WaterController;
use App\Model\UserModel;
use App\Model\TokenModel;
use App\Model\WaterCountModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new DB();

$user = new UserModel($db->getConnect());
$water = new WaterCountModel($db->getConnect());
$token = new TokenModel($db->getConnect());
$waterController = new WaterController($user, $water);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    verifyExistsToken();
    verifyIfTokenIsValid();
    
    // Get the ranking.
    echo json_encode($waterController->getRanking());
    die;

}
else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not allowed']);
    die;
}