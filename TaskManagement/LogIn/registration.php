<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT * FROM userr WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Username or email already taken.");
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO userr (name, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $email, $password);
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="register">
    <h2>Register</h2>
    <form method="POST" action="registration.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Register">
        <a href="login.php">Login</a>
        
    </form>
</div>
</body>
</html>
