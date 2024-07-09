<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Search functionality
$search = isset($_GET['query']) ? $_GET['query'] : '';
$searchCondition = '';
$params = [];
if (!empty($search)) {
    $searchCondition = "AND (t.title LIKE ? OR t.description LIKE ?)";
    $params = ["%$search%", "%$search%"];
}

// Fetch tasks from the database
$query = "SELECT t.taskID, t.title, t.description, t.due, t.status, u.username
          FROM task t
          INNER JOIN userr u ON t.userID = u.userID
          WHERE 1=1 $searchCondition";
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Count total tasks
$totalTasks = $result->num_rows;
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <h2><a href="../homepage.php">Dashboard<a></h2>
        <ul>
            <li><a href="../TaskManagement/Task/pending.php">Pending</a></li>
            <li><a href="../TaskManagement/Task/inProgress.php">In Progress</a></li>
            <li><a href="../TaskManagement/Task/completed.php">Completed</a></li>
            <li><a href="../TaskManagement/Task/calender.php">Calender</a></li>
        </ul>
</aside>
        <!-- ... (header and sidebar code remains unchanged) ... -->
        <div class="main-content">
            <div class="top-bar">
                <div>
                    <button onclick="location.href='../TaskManagement/Functions/create.php';">Create Task</button>
                </div>
                <div>
                    <form id="searchForm" action="" method="GET">
                        <input type="text" id="query" name="query" placeholder="Search tasks..." value="<?php echo htmlspecialchars($search); ?>">
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
                        if ($result->num_rows > 0) {
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
                        } else {
                            echo "<tr><td colspan='7'>No tasks found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>
            <center><button onclick="location.href='../homepage.php'">Cancel</button></center>
        </div>
    </div>
    <!-- ... (JavaScript code remains unchanged) ... -->
</body>
</html>