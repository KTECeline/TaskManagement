<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        die("Email is required.");
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM userr WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Redirect to the reset password page with the email as a parameter
        header("Location: resetPW.php?email=" . urlencode($email));
        exit();
    } else {
        echo "No account found with that email.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="forgot-password">
        <h2>Forgot Password</h2>
        <form method="POST" action="forgotPW.php">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
            <input type="submit" value="Submit">
            <br>
            <a href="login.php">Back</a>
        </form>

    </div>
</body>
</html>
