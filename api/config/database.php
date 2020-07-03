<?php
    class Database {
        // Specify database credentials
        private $host = "localhost";
        private $db_name = "api_db";
        private $username = "root";
        private $password = "";
        public $conn;

        // Get the database connection
        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = 
                new PDO("mysql:host=" .$this->host. ";dbname=" .$this->db_name,$this->username,$this->password);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                die("Error: " . $exception->getMessage());
            }

            return $this->conn;
        }
    }