<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Fetch the user from the database
    $stmt = $conn->prepare("SELECT * FROM userr WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['userID'];
        $_SESSION['username'] = $row['username'];
        echo "Login successful!";

        header("Location: /TaskManagement/homepage.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Login">
        <br>
        <a href="registration.php">Sign Up</a>
        <a href="forgotPW.php">Forgot Password</a>
    </form>
</div>
</body>
</html>
