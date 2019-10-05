<?php

require '../vendor/autoload.php';

use App\Model\TokenModel;

/**
 * Get url parameters
 * 
 * @param string $url
 * 
 * @return array
 */
function getUrlParameters(string $url) {
    $url = parse_url($url);
    return explode('/', $url['path']);
}

/**
 * Get token
 * 
 * @param string $tokenParameter
 * 
 * @return array
 */
function getToken(string $tokenParameter) {
    $token = new TokenModel($GLOBALS['db']->getConnect());
    return $token->getToken($tokenParameter);
}

/**
 * Verify if there is a token.
 * 
 * @return http_response_code|string
 */
function verifyExistsToken() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(404);
        echo json_encode(['error' => 'Missing token']);
        die;
    }
}

/**
 * Veirfy if token if valid.
 * 
 * @return http_response_code|array
 */
function verifyIfTokenIsValid() {
    $headers = apache_request_headers();
    $hasToken = getToken($headers['Authorization']);

    if (!$hasToken)  {
        http_response_code(404);
        echo json_encode(['error' => 'Token invalid']);
        die;
    }

    return $hasToken;
}