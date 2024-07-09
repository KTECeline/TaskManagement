<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs (assuming sanitized and validated on client-side)
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due = $_POST['due'];
    $status = $_POST['status'];
    $userID = $_SESSION['user_id']; // Assuming you have stored user_id in session

    // Insert task into database
    $stmt = $conn->prepare("INSERT INTO task (title, description, due, status, userID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $due, $status, $userID);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: /TaskManagement/homepage.php"); // Redirect to homepage after adding task
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <link rel="stylesheet" href="../css/edit.css"> <!-- Adjust the path as needed -->
</head>
<body>
<div class="modal-content">
    <div class="container">
        <h2>Create Task</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" required></textarea><br><br>

            <label for="due">Due Date:</label><br>
            <input type="date" id="due" name="due" required><br><br>

            <label for="status">Status:</label><br>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select><br><br>

            <input type="submit" value="Add Task">
            <a href="/TaskManagement/homepage.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>
