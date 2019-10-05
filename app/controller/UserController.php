<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\WaterCountModel;

class UserController {

    /**
     * User model
     * 
     * @var App\Model\UserModel $user
     */
    protected $user;

    public function __construct(UserModel $user, WaterCountModel $water) {
        $this->user = $user;
        $this->water = $water;
    }

    /**
     * List all users
     * 
     * @return array
     */
    public function index() {
        $users = $this->user->getAll();
        $return = [];

        foreach ($users as $user) {
            $waterCount = $this->water->getWaterCountQuantity($user['id']);
            $return[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'drink_counter' => (empty($waterCount['quantity'])) ? 0 : $waterCount['quantity'],
            ];
        }

        return $return;
    }

    /**
     * Get a specific user
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getUser(int $id) {
        $user = $this->user->get($id);
        $waterCount = $this->water->getWaterCountQuantity($user['id']);

        $return = [
            'iduser' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'drink_counter' => (empty($waterCount['quantity'])) ? 0 : $waterCount['quantity'],
        ];

        return $return;
    }

    /**
     * Create user
     * 
     * @param array $parameters
     * 
     * @return bool|array
     */
    public function createUser(array $parameters) {
        return $this->user->create($parameters);
    }

    /**
     * Edit user
     * 
     * @param int $id
     * @param array $parameters
     * 
     * @return bool
     */
    public function editUser(int $id, array $parameters) {
        $user = $this->user->update($id, $parameters);

        return $user;
    }

    /**
     * Delete user
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function deleteUser(int $id) {
        return $this->user->delete($id);
    }

    /**
     * Count how much water the user drink
     * 
     * @param int $id
     * @param array $parameters
     * 
     * @return bool|array
     */
    public function addWater(int $id, array $parameters) {
        $user = $this->user->get($id);
        $water = $this->water->create($id, $parameters);

        if ($water) {
            $waterCount = $this->water->getWaterCountQuantity($id);
        }
        else {
            return FALSE;
        }

        $return = [
            'iduser' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'drink_counter' => (empty($waterCount['quantity'])) ? 0 : $waterCount['quantity'],
        ];

        return $return;
    }

}