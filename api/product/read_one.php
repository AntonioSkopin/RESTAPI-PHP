<?php
    // Required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    // Include database and object files
    include_once "../config/database.php";
    include_once "../objects/product.php";

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Prepare product object
    $product = new Product($db);

    // Set ID property of record to read
    $product->id = isset($_GET["id"]) ? $_GET["id"] : die();

    // Read the details of product to be edited
    $product->readOne();

    if ($product->name != null) {
        // Create array
        $product_arr = array (
            "id" =>  $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
            "category_id" => $product->category_id,
            "category_name" => $product->category_name
        );

        // Set response code to 200 (OK)
        http_response_code(200);

        // Make it json format
        echo json_encode($product_arr);
    }