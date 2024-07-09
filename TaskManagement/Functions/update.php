<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskID = $_POST['taskID'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due = $_POST['due'];
    $status = $_POST['status'];

    // Update task in the database
    $stmt = $conn->prepare("UPDATE task SET title = ?, description = ?, due = ?, status = ? WHERE taskID = ?");
    $stmt->bind_param("ssssi", $title, $description, $due, $status, $taskID);

    if ($stmt->execute()) {
        // Task updated successfully
        echo "<script>alert('Task updated successfully!');</script>";
        echo "<script>window.location.href = '../homepage.php';</script>"; // Redirect to homepage after updating task
        exit();
    } else {
        // Error updating task
        echo "Error updating task: " . $stmt->error;
        // Optionally log the error for debugging
        // error_log($stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
