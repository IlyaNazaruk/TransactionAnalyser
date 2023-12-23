<?php

class Database
{
    private $conn;

    private string $serverName = 'mysql';
    private string $database = 'database';
    private string $username = 'username';
    private string $password = 'password';
    function __construct()
    {
        $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}
