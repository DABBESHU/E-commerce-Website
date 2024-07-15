<?php
session_start();

// Check if the user is already logged in, if yes, redirect to home.html
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.html");
    exit;
}

// Check if username and password are submitted
if(isset($_POST["username"]) && isset($_POST["password"])) {
    // Change these variables to match your database credentials
    $db_host = 'localhost';
    $db_username = 'id21830482_anushrigurav';
    $db_password = 'Anushri$07';
    $db_name = 'id21830482_anushri';

    // Connect to the database
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to fetch the user
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user is found, start a new session and redirect to home.html
    if($result->num_rows == 1) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("location: home.html");
        exit;
    } else {
        // Display an alert message for incorrect credentials
        echo "<script>alert('Invalid username or password');</script>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }
        .login-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-btn {
            background-color: #7B68EE;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #6A5ACD;
        }
        .signup-link {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required style="border-radius: 5px; padding: 8px;"><br><br>
            <input type="password" name="password" placeholder="Password" required style="border-radius: 5px; padding: 8px;"><br><br>
            <input type="submit" value="Login" class="login-btn">
        </form>
        <p class="signup-link">Don't have an account? <a href="signup.php">Sign-up</a></p>
    </div>
</body>
</html>
