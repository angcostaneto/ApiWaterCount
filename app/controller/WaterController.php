<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\WaterCountModel;

class WaterController {

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
     * Get history from a spefic user
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getWaterCount(int $id) {
        $waters = $this->water->getWaterCount($id);
        $return = [];

        foreach ($waters as $water) {
            $return[] = [
                'quantity' => $water['quantity'],
                'date' => $water['date'],
            ];
        }

        return $return;
    }

    /**
     * Get the ranking who drinked more water in current date
     * 
     * @return array
     */
    public function getRanking() {
        $waters = $this->water->getRanking();
        $return = [];

        foreach ($waters as $water) {
            $return[] = [
                'name' => $water['name'],
                'quantity' => $water['ml']
            ];
        }

        return $return;
    }

}