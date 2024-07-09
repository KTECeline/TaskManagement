<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    // Prepare statement to delete task
    $stmt = $conn->prepare("DELETE FROM task WHERE taskID = ?");
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "error";
}

$conn->close();
?>
