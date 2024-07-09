<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';

// Fetch tasks from the database
$query = "SELECT * FROM task";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format each task row as HTML
        echo '<tr>';
        echo '<td>' . $row['taskID'] . '</td>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
        echo '<td>' . htmlspecialchars($row['due']) . '</td>';
        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
        echo '<td>' . htmlspecialchars($row['userID']) . '</td>';
        echo '<td><button>Edit</button><button>Delete</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">No tasks found</td></tr>';
}

$conn->close();
?>
