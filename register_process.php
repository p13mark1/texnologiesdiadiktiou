<?php
require_once('config.php');

// Function to clean and sanitize user inputs
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clean and sanitize input data
    $name = clean_input($_POST["name"]);
    $surname = clean_input($_POST["surname"]);
    $username = clean_input($_POST["username"]);
    $password = clean_input($_POST["password"]);
    $email = clean_input($_POST["email"]);
    $simplepushKey = clean_input($_POST["simplepush_key"]);

    // Validate and save the data to the database
    $db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
    }

    // Check if username or email already exists in the database
    $check_username_query = "SELECT * FROM users WHERE username='$username'";
    $check_email_query = "SELECT * FROM users WHERE email='$email'";

    $result_username = $db_connection->query($check_username_query);
    $result_email = $db_connection->query($check_email_query);

    if ($result_username->num_rows > 0) {
        header("Location: register.php?error=username");
        exit();
    } elseif ($result_email->num_rows > 0) {
        header("Location: register.php?error=email");
        exit();
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query
        $insert_query = "INSERT INTO users (name, surname, username, password, email, simplepush_key) VALUES ('$name', '$surname', '$username', '$hashed_password', '$email', '$simplepushKey')";

        if ($db_connection->query($insert_query) === TRUE) {
            header("Location: user_page.php");
            exit();
        } else {
            header("Location: register.php?error=unknown");
            exit();
        }
    }

    $db_connection->close();
}
?>
