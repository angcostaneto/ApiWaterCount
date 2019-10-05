<?php

require '../vendor/autoload.php';
require '../utils/utils.php';

use App\Config\DB;
use App\Controller\UserController;
use App\Model\UserModel;
use App\Model\WaterCountModel;

$db = new DB();

$user = new UserModel($db->getConnect());
$water = new WaterCountModel($db->getConnect());
$userController = new UserController($user, $water);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = getUrlParameters($_SERVER['REQUEST_URI']);

    $_POST = json_decode(file_get_contents('php://input'), true);

    // See if the url is /users/{id}/drink
    if (isset($url[2]) && isset($url[3]) && $url[3] == 'drink') {
        verifyExistsToken();
        verifyIfTokenIsValid();

        $user = $userController->addWater($url[2], $_POST);

        if ($user) {
            echo json_encode($user);
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'Occurs some error to add water quantity']);
            die;
        }

    }
    // Create user.
    else {
        $created = $userController->createUser($_POST);

        if ($created['error']) {
            http_response_code(404);
            echo json_encode($created);
            die;
        } else if ($created) {
            echo json_encode(['success' => 'User created with success']);
            die;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Error in creating user']);
            die;
        }   
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $url = getUrlParameters($_SERVER['REQUEST_URI']);

    verifyExistsToken();
    $hasToken = verifyIfTokenIsValid();

    // Verify if has an id in url, if no, get all else get a specifc user
    if (!isset($url[2])) {
        echo json_encode($userController->index());
        die;
    }
    else {
        echo json_encode($userController->getUser($url[2]));
        die;
    }

}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $url = getUrlParameters($_SERVER['REQUEST_URI']);

    $_POST = json_decode(file_get_contents('php://input'), true);

    verifyExistsToken();
    $hasToken = verifyIfTokenIsValid();

    // See if has id in url to update user
    if ($hasToken['user_id'] == $url[2]) {
        $user = $userController->editUser($url[2], $_POST);
        if ($user !== FALSE) {
            echo json_encode(['success' => 'User was update with success']);
            die;
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'Error on update user']);
            die;
        }
    }
    else {
        http_response_code(404);
        echo json_encode(['error' => 'Cannot update other user only yours']);
        die;
    }
} 
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $url = getUrlParameters($_SERVER['REQUEST_URI']);
    
    verifyExistsToken();
    $hasToken = verifyIfTokenIsValid();

    // See if has id in url to delete user
    if ($hasToken['user_id'] == $url[2]) {
        if ($userController->deleteUser($url[2]) !== FALSE) {
            echo json_encode(['success' => 'User was delete with success']);
            die;
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'Error on delete user']);
            die;
        }
    }
    else {
        http_response_code(404);
        echo json_encode(['error' => 'Cannot delete other user only yours']);
        die;
    }
}
else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not allowed']);
    die;
}
