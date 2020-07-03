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

        // Read the products
        function read() {
            
            // Select all query
            $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
            
            // Prepare the query statement
            $stmt = $this->conn->prepare($query);

            // Execute the query
            $stmt->execute();

            return $stmt;
        }
    }