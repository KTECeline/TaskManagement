<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Query to count tasks based on their status
$query = "SELECT status, COUNT(*) as count FROM task GROUP BY status";
$result = $conn->query($query);

$taskStatusData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taskStatusData[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($taskStatusData);
?>
