<?php

namespace App\Model;

use PDO;

class WaterCountModel
{
    /**
     * User id
     * 
     * @var int $user_id
     */
    public $user_id;

    /**
     * Quantity of water.
     * 
     * @var int $quantity
     */
    public $quantity;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Create a register for water count
     * 
     * @param int $id
     * @param array $parameters
     * 
     * @return bool
     */
    public function create(int $user_id, array $parameters) {
        if (!empty($parameters['drink_ml']) && is_int($parameters['drink_ml'])) {
            $query = "INSERT INTO water_count (user_id, quantity) VALUES ({$user_id}, {$parameters['drink_ml']})";
            $water = $this->db->prepare($query);

            return $water->execute();
        }
        else {
            return FALSE;
        }
    }

    /**
     * Get all the register of water count.
     * 
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM water_count";

        $water = $this->db->prepare($query);
        $water->execute();

        return $water->fetchAll();
    }

    /**
     * Get quantity of times that user register.
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getWaterCountQuantity(int $id) {
        $query = "SELECT count(*) quantity FROM water_count WHERE user_id = $id";

        $water = $this->db->prepare($query);
        $water->execute();

        return $water->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all register of water count for specific user
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getWaterCount(int $id) {
        $query = "SELECT * FROM water_count WHERE user_id = $id ORDER BY date";

        $water = $this->db->prepare($query);
        $water->execute();

        return $water->fetchAll();
    }

    /**
     * Get ranking from current date.
     * 
     * @return array
     */
    public function getRanking() {
        $date = date('Y-m-d');
        $query = "SELECT 
                users.name name,
                sum(quantity) ml
            FROM water_count
            JOIN users ON users.id = water_count.id
            WHERE water_count.date LIKE '{$date} %'
            GROUP BY users.name
            ORDER BY ml";

        $water = $this->db->prepare($query);
        $water->execute();

        return $water->fetchAll();
    }
}
