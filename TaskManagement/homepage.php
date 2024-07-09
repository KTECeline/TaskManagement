
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
          INNER JOIN userr u ON t.userID = u.userID";
$result = $conn->query($query);
// Count total tasks
$totalTasks = $result->num_rows;
$conn->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Management System</title>
    <link rel="stylesheet" href="../TaskManagement/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <style>
        .sidebar a:hover{
            padding: 10px;
            width: 30px;
            background-color: #60aae2;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>'s Task Manager</h1>
            <p><a href="../TaskManagement/LogIn/logout.php">Logout</a></p>
            </div>
        </header>
    <aside class="sidebar">
        <h2><a href="homepage.php">Dashboard<a></h2>
        <div class="sidebar-menu">
        <ul>
            <li><a href="../TaskManagement/Task/pending.php">Pending</a></li>
            <li><a href="../TaskManagement/Task/inProgress.php">In Progress</a></li>
            <li><a href="../TaskManagement/Task/completed.php">Completed</a></li>
            <li><a href="../TaskManagement/Task/calendar.php">Calendar</a></li>
            
        </ul>
</div>
</aside>
    <div class="main-content">
        <div class="top-bar">
            <div>
                <button onclick="location.href='../TaskManagement/Functions/create.php';">Create Task</button>
            </div>
            <div>
                        <!-- Add this within your HTML body where you want the search bar -->
            <form id="searchForm" action="../TaskManagement/Functions/search.php" method="GET">
                <input type="text" id="query" name="query" placeholder="Search tasks...">
                <button type="submit">Search</button>
            </form>
            </div>
        </div>

        <div class="task-table">
            <table id="taskTable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Assignees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1; // Initialize counter for numbering
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr id="taskRow_<?php echo $row['taskID']; ?>">
                            <td><?php echo $counter; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['due']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td>
                                <button class="edit-task" data-taskid="<?php echo $row['taskID']; ?>">Edit</button>
                                <button class="delete-task" data-taskid="<?php echo $row['taskID']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php
                        $counter++; // Increment counter for next row
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
   
    <script>
$(document).ready(function() {
            
        $(document).ready(function() {
            // AJAX request to delete task
            $(".delete-task").click(function() {
                var taskId = $(this).data('taskid');
                var confirmation = confirm("Are you sure you want to delete this task?");
                if (confirmation) {
                    $.ajax({
                        url: '../TaskManagement/Functions/delete-task.php',
                        type: 'POST',
                        data: { taskId: taskId },
                        success: function(response) {
                            if (response == "success") {
                                // Remove the deleted task row from the table
                                $("#taskRow_" + taskId).remove();
                                alert("Task deleted successfully!");
                                updateTaskNumbers(); // Update task numbers after deletion
                            } else {
                                alert("Failed to delete task.");
                            }
                        },
                        error: function() {
                            alert("Error: Unable to delete task.");
                        }
                    });
                }
            });});
            // Example: Implement search functionality if needed
            $("#searchButton").click(function() {
                var searchInput = $("#searchInput").val();
                // Implement search logic here
            });
            // Function to update task numbers
            function updateTaskNumbers() {
                var tableRows = $(".task-table tbody tr");
                tableRows.each(function(index) {
                    $(this).find("td:first-child").text(index + 1);
                });
            }
        });

       
    </script>
</body>
</html>

