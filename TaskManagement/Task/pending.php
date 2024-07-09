<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Fetch tasks from the database
$query = "SELECT t.taskID, t.title, t.description, t.due, t.status, u.username
          FROM task t
          INNER JOIN userr u ON t.userID = u.userID
          WHERE t.status = 'pending'";
$result = $conn->query($query);
// Count total tasks
$totalTasks = $result->num_rows;
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending - Task Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/card.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>'s Task Manager</h1>
                <p><a href="../TaskManagement/LogIn/logout.php">Logout</a></p>
            </div>
        </header>
        <aside class="sidebar">
        <h2><a href="../homepage.php">Dashboard<a></h2>
            <ul>
                <li><a href="../Task/pending.php">Pending</a></li>
                <li><a href="../Task/inProgress.php">In Progress</a></li>
                <li><a href="../Task/completed.php">Completed</a></li>
                <li><a href="../Task/calendar.php">Calendar</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <h2>Pending Tasks</h2>
            <div class="card-container">
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                <div class="task-card" id="taskCard_<?php echo $row['taskID']; ?>">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($row['due']); ?></p>
                    <p><strong>Assignee:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
                    <span class="statusP">Pending</span>
                    <div class="actions">
                        <button class="edit-task" data-taskid="<?php echo $row['taskID']; ?>">Edit</button>
                        <button class="delete-task" data-taskid="<?php echo $row['taskID']; ?>">Delete</button>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </main><button onclick="location.href='../homepage.php';">Cancel</button>
        
        
    </div>
    
            
    <script>
        $(document).ready(function() {
            $(".delete-task").click(function() {
                var taskId = $(this).data('taskid');
                var confirmation = confirm("Are you sure you want to delete this task?");
                if (confirmation) {
                    $.ajax({
                        url: '../Functions/delete-task.php',
                        type: 'POST',
                        data: { taskId: taskId },
                        success: function(response) {
                            if (response == "success") {
                                $("#taskCard_" + taskId).remove();
                                alert("Task deleted successfully!");
                            } else {
                                alert("Failed to delete task.");
                            }
                        },
                        error: function() {
                            alert("Error: Unable to delete task.");
                        }
                    });
                }
            });

            $(".edit-task").click(function() {
                var taskId = $(this).data('taskid');
                window.location.href = '../Functions/edit.php?taskID=' + taskId;
            });
        });
    </script>
</body>
</html>



