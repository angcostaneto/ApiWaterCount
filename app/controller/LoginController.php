<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\TokenModel;
use App\Model\WaterCountModel;

class LoginController {
    
    /**
     * User model
     * 
     * @var App\Model\UserModel $user
     */
    protected $user;

    /**
     * User model
     * 
     * @var App\Model\TokenModel $token
     */
    protected $token;

    public function __construct(UserModel $user, TokenModel $token, WaterCountModel $water) {
        $this->user = $user;
        $this->token = $token;
        $this->water = $water;
    }

    /**
     * Make login.
     * 
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function makeLogin(string $email, string $password) {
        $user = $this->user->findUserByEmailPassword($email, $password);
        
        if ($user) {
            $waterCount = $this->water->getWaterCountQuantity($user['id']);
            $token = "{$user['email']}:{$user['name']}";

            $token = hash('sha256', $token);

            if (!isset($this->token->getToken($token)['token'])) {
                $this->token->create(['user_id' => $user['id'], 'token' => $token]);
            }

            $return = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'drink_counter' => (empty($waterCount['quantity'])) ? 0 : $waterCount['quantity'],
                'token' => $token,
            ];

            return $return;
        }
    }

    /**
     * Make logout.
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function logout(string $token) {
        return $this->token->delete($token);
    }
}