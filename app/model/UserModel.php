<?php

namespace App\Model;

use PDO;

class UserModel
{
    /**
     * Name of user
     * 
     * @var string $name
     */
    public $name;

    /**
     * Password of user
     * 
     * @var string $password
     */
    private $password;

    /**
     * Email of user
     * 
     * @var string $email
     */
    public $email;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Find user by email and password
     * 
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function findUserByEmailPassword(string $email, string $password) {
        $query = "SELECT id, name, email FROM users where email = '{$email}' and password = '{$password}'";

        $users = $this->db->prepare($query);
        $users->execute();

        return $users->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create user
     * 
     * @param array $parameters
     * 
     * @return bool|array
     */
    public function create(array $parameters) {
        if (!empty($parameters['name']) && !empty($parameters['password']) && !empty($parameters['email'])) {
            $query = "SELECT id FROM users where email = '{$parameters['email']}'";
            $users = $this->db->prepare($query);
            $users->execute();

            if (!$users->fetch(PDO::FETCH_ASSOC)) {
                $query = "INSERT INTO users (name, password, email) VALUES ('{$parameters['name']}', '{$parameters['password']}', '{$parameters['email']}')";
            
                $users = $this->db->prepare($query);
                return $users->execute();
            }
            else {
                return ['error' => 'User with this email already exists'];
            }
        }

        return FALSE;
    }

    /**
     * Update user
     * 
     * @param int $id
     * @param array $parameters
     * 
     * @return bool
     */
    public function update(int $id, array $parameters) {
        $query = "SELECT id FROM users where id = '{$id}'";
        $users = $this->db->prepare($query);
        $users->execute();

        if ($users->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($parameters['name']) && !empty($parameters['password']) && !empty($parameters['email'])) {
                $query = "UPDATE users set name = '{$parameters['name']}' , password = '{$parameters['password']}', email = '{$parameters['email']}' WHERE id = {$id}";
                
                $users = $this->db->prepare($query);
                $users->execute();

                return $users->execute();
            }
            else {
                return FALSE;
            }
        }
        else {
            return FALSE;
        }
    }

    /**
     * Get all users
     * 
     * @return array
     */
    public function getAll() {
        $query = "SELECT id, name, email FROM users";

        $users = $this->db->prepare($query);

        $users->execute();

        return $users->fetchAll();
    }
    
    /**
     * Get user
     * 
     * @param int $id
     * 
     * @return array
     */
    public function get(int $id) {
        $query = "SELECT id, name, email FROM users WHERE id = {$id}";

        $user = $this->db->prepare($query);

        $user->execute();

        return $user->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete user
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id) {
        $query = "DELETE FROM users WHERE id = {$id}";

        $user = $this->db->prepare($query);

        return $user->execute();
    }
}
