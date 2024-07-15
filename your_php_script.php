<?php
// Database connection
$servername = "localhost";
$username = "id21830482_anushrigurav";
$password = "Anushri$07";
$database = "id21830482_anushri";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email field is set and not empty
    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        $email = $_POST["email"];

        // Prepare and bind parameters
        $check_stmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        // Check if email already exists
        if ($result->num_rows > 0) {
            echo "Email already exists in the database.";
        } else {
            // Prepare and bind parameters for insertion
            $insert_stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
            $insert_stmt->bind_param("s", $email);

            // Execute the statement
            if ($insert_stmt->execute()) {
                echo "New record created successfully.";
            } else {
                echo "Error: " . $insert_stmt->error;
            }
        }

        // Close statements
        $check_stmt->close();
        $insert_stmt->close();
    } else {
        echo "Email address is required.";
    }
} else {
    // Redirect if accessed directly
    header("Location: /");
}

// Close connection
$conn->close();
?>
