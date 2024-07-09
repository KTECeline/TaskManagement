<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE userr SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $password, $email);
    if ($stmt->execute()) {
        echo "<script>alert('Password has been reset successfully!'); window.location.href='login.php';</script>";
        
    } else {
        echo "<script>alert('Failed to reset password.'); window.location.href='forgotPW.php';</script>";;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="reset-password">
        <h2>Reset Password</h2>
        <form method="POST" action="resetPW.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <label for="password">New Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password"><br>
            <input type="submit" value="Reset Password">
            <a href="forgotPW.php">Back</a>
    </div>
</body>
</html>