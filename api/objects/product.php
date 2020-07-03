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
            $this->conn = $db;
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

        // Create a product
        function create() {

            // Query to insert record
            $query = "INSERT INTO ".$this->table_name." SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
            
            // Prepare query
            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));
            $this->created=htmlspecialchars(strip_tags($this->created));

            // Bind the values
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":created", $this->created);

            // Execute the query
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }