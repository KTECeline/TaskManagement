<?php
require 'C:/xampp1/htdocs/TaskManagement/conn.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the current month and year, or the selected month and year
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Query to fetch tasks for the selected month
$query = "SELECT taskID, title, status, due
          FROM task
          WHERE MONTH(due) = ? AND YEAR(due) = ?
          ORDER BY due";

$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $month, $year);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// Function to generate month options
function generateMonthOptions($selectedMonth) {
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
    foreach ($months as $num => $name) {
        $selected = ($num == $selectedMonth) ? 'selected' : '';
        echo "<option value='$num' $selected>$name</option>";
    }
}

// Function to generate year options
function generateYearOptions($selectedYear) {
    $currentYear = date('Y');
    for ($year = $currentYear - 5; $year <= $currentYear + 5; $year++) {
        $selected = ($year == $selectedYear) ? 'selected' : '';
        echo "<option value='$year' $selected>$year</option>";
    }
}

// Get the first and last days of the month
$firstDayOfMonth = strtotime("$year-$month-01");
$lastDayOfMonth = strtotime("last day of", $firstDayOfMonth);

// Get the first and last days of the calendar view (including previous and next months)
$startOfCalendar = strtotime("last Sunday", $firstDayOfMonth);
$endOfCalendar = strtotime("next Saturday", $lastDayOfMonth);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Calendar</title>
    <link rel="stylesheet" href="../css/calendar.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="calendar-container">
        <form method="GET" action="calendar.php">
            <select name="month" onchange="this.form.submit()">
                <?php generateMonthOptions($month); ?>
            </select>
            <select name="year" onchange="this.form.submit()">
                <?php generateYearOptions($year); ?>
            </select>
        </form>
        
        <div class="calendar">
            <div class="calendar-header">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="calendar-body">
                <?php
                // Initialize current day to the start of the calendar view
                $currentDay = $startOfCalendar;

                while ($currentDay <= $endOfCalendar) {
                    $day = date('j', $currentDay);
                    $monthNum = date('n', $currentDay);
                    $yearNum = date('Y', $currentDay);

                    // Start a new row for each week
                    if (date('w', $currentDay) == 0) {
                        echo "<div class='calendar-row'>";
                    }

                    // Add a cell for each day
                    echo "<div class='calendar-cell'>";
                    if ($monthNum == $month && $yearNum == $year) {
                        echo "<div class='calendar-date'>$day</div>";

                        // Display tasks for this date
                        foreach ($tasks as $task) {
                            if (date('Y-m-d', strtotime($task['due'])) == date('Y-m-d', $currentDay)) {
                                echo "<div class='task'>{$task['title']} - {$task['status']}</div>";
                            }
                        }
                    }
                    echo "</div>";

                    // End the row for each week
                    if (date('w', $currentDay) == 6) {
                        echo "</div>";
                    }

                    // Move to the next day
                    $currentDay = strtotime('+1 day', $currentDay);
                }
                ?>
            </div>
        </div>
    </div>
	<br>
	<center><button class="cancel-btn" onclick="location.href='../homepage.php';">Cancel</button></center>
</body>
</html>
<?php
$conn->close();
