<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

$response = array('success' => false, 'message' => 'Error deleting task');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['taskID'])) {
    $taskID = $_POST['taskID'];

    // Prepare SQL statement to delete task by taskID
    $stmt = $conn->prepare("DELETE FROM task WHERE taskID = ?");
    $stmt->bind_param("i", $taskID);

    if ($stmt->execute()) {
        // Task deleted successfully
        $response['success'] = true;
        $response['message'] = 'Task deleted successfully!';
        
        // Fetch updated task list
        $query = "SELECT * FROM task";
        $result = $conn->query($query);
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        $response['tasks'] = $tasks;
    } else {
        // Error deleting task
        $response['message'] = 'Error deleting task: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
