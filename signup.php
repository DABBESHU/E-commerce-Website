<?php
if(isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to your database
    
    $db_host = 'localhost';
    $db_username = 'id21830482_anushrigurav';
    $db_password = 'Anushri$07';
    $db_name = 'id21830482_anushri';

    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $query);

    if($result) {
        // Redirect to home.html
        header("Location: home.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }
        .signup-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .signup-btn {
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
        .signup-btn:hover {
            background-color: #6A5ACD;
        }
        .login-link {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="signup-box">
        <h2>Signup</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required style="border-radius: 5px; padding: 8px;"><br><br>
            <input type="password" name="password" placeholder="Password" required style="border-radius: 5px; padding: 8px;"><br><br>
            <input type="submit" name="signup" value="Signup" class="signup-btn">
        </form>
        <p class="login-link">Already have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
