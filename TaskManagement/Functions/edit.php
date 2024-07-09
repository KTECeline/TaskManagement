
<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Check if taskID is provided in the URL
if (!isset($_GET['taskID'])) {
    die("Task ID not specified.");
}
$taskID = $_GET['taskID'];
// Fetch task details from the database
$stmt = $conn->prepare("SELECT * FROM task WHERE taskID = ?");
$stmt->bind_param("i", $taskID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Task not found.");
}
$row = $result->fetch_assoc();
$title = $row['title'];
$description = $row['description'];
$due = $row['due'];
$status = $row['status'];
$userID = $row['userID'];
$stmt->close();
$conn->close();
?>
<div class="modal-content">
    
    <h2>Edit Task</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="taskID" value="<?php echo $taskID; ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea><br><br>
        <label for="due">Due Date:</label><br>
        <input type="date" id="due" name="due" value="<?php echo $due; ?>" required><br><br>
        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="Pending" <?php if ($status === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if ($status === 'In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Completed" <?php if ($status === 'Completed') echo 'selected'; ?>>Completed</option>
        </select><br><br>
        <input type="submit" value="Update Task">
        <a href="/TaskManagement/homepage.php" class="cancel-btn">Cancel</a>
    </form>
</div>
<link rel="stylesheet" href="../css/edit.css">
