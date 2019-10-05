<?php

namespace App\Model;

use PDO;
use PDOException;

class TokenModel
{
    /**
     * User id
     * 
     * @var int $user_id
     */
    public $user_id;

    /**
     * Token for session.
     * 
     * @var string $token
     */
    public $token;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Create token
     * 
     * @param array $parameters
     * 
     * @return bool
     */
    public function create(array $parameters) {
        if (!empty($parameters['user_id']) && !empty($parameters['token'])) {
            $query = "INSERT INTO tokens (user_id, token) VALUES ({$parameters['user_id']}, '{$parameters['token']}')";
            
            $token = $this->db->prepare($query);
            $token->execute();

            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Get token
     * 
     * @param string $token
     * 
     * @return array
     */
    public function getToken(string $token) {
        $query = "SELECT * FROM tokens WHERE token = '{$token}'";

        $token = $this->db->prepare($query);
        $token->execute();

        return $token->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete token
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function delete(string $token) {
        $query = "DELETE FROM tokens WHERE token = '{$token}'";

        $token = $this->db->prepare($query);
        return $token->execute();
    }
}
