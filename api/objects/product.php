<?php
    class Product {
        // Database connectio and table name
        private $conn;
        private $table_name = "products";

        // Object properties
        public $id;
        public $name;
        public $description;
        public $price;
        public $category_id;
        public $category_name;
        public $created;

        // Constructor with $db as database connection
        public function __construct($db) {
            this->conn = $db;
        }
    }