<?php
    // Required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // Get database connection
    include_once '../config/database.php';

    // Instantiate product object
    include_once '../objects/product.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure data is not empty
    if (
        !empty($data->name) &&
        !empty($data->price) &&
        !empty($data->description) &&
        !empty($data->category_id)
    ) {
        // Set product property values
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        $product->category_id = $data->category_id;
        $product->created = date('Y-m-d H:i:s');

        // Create the product
        if ($product->create()) {
            // Set response code to 201 (Created)
            http_response_code(201);

            // Output it to the user
            echo json_encode(array("message" => "Product was created"));
        }
        // If unable to create the product, output it to the user
        else {
            // Set response code to 502 (Service unavailable)
            http_response_code(502);

            // Output it to the user
            echo json_encode(array("message" => "Unable to create product."));
        }
    }
    // Tell user data is incomplete
    else {
        // Set response code to 400 (Bad request)
        http_response_code(400);

        // Output it to the user
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }