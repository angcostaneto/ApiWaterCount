<?php

namespace App\Config;

use PDO;
use PDOException;

class DB 
{
    /**
     * The host name.
     * 
     * @var string $host
     */
    private $host = 'localhost';

    /**
     * The database name.
     * 
     * @var string $dbName
     */
    private $dbName = 'water_count';
    
    /**
     * The username.
     * 
     * @var string $username
     */
    private $username = 'root';
    
    /**
     * The passowrd from user.
     * 
     * @var string $password
     */
    private $password = '123456';
    
    /**
     * The connection with database.
     * 
     * @var string $connection
     */
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbName}", "{$this->username}", "{$this->password}");
            $this->connection->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    /**
     * Return the connection with database.
     */
    public function getConnect() {
        return $this->connection;
    }
}
