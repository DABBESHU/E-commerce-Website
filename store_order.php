<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the POST request
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    // Data validation
    if (empty($product_name) || empty($product_price) || empty($customer_name) || empty($customer_phone) || empty($customer_email) || empty($customer_address)) {
        http_response_code(400); // Bad request
        echo json_encode(array("error" => "All fields are required."));
        exit;
    }

    // Database connection parameters
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    try {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO orders (product_name, product_price, customer_name, customer_phone, customer_email, customer_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $product_name, $product_price, $customer_name, $customer_phone, $customer_email, $customer_address);

        // Execute the SQL statement
        if ($stmt->execute() === TRUE) {
            echo json_encode(array("message" => "Order stored successfully"));
        } else {
            throw new Exception("Error executing SQL statement: " . $stmt->error);
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal server error
        echo json_encode(array("error" => $e->getMessage()));
    } finally {
        // Close statement and database connection
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
} else {
    // If the request method is not POST, return an error message
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Invalid request method"));
}
?>
