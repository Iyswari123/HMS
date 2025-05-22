<?php
include('../includes/dbconn.php');
session_start();

$sid = $_POST['sid'] ?? '';
$month = $_POST['month'] ?? '';
$year = $_POST['year'] ?? '';

// Validate student ID
if (empty($sid)) {
    echo "<tr><td colspan='6' class='text-center text-danger'>Invalid Student ID.</td></tr>";
    exit;
}

// Build base query
$query = "SELECT MONTH(date) as month, YEAR(date) as year, 
                 SUM(status = 1) as present_days, 
                 COUNT(*) as total_days 
          FROM attendance 
          WHERE sid = ?";
$types = "i";
$params = [$sid];

// Add month filter if set
if (!empty($month)) {
    $monthNum = date('n', strtotime($month)); // Convert "April" to 4
    $query .= " AND MONTH(date) = ?";
    $types .= "i";
    $params[] = $monthNum;
}

// Add year filter if set
if (!empty($year)) {
    $query .= " AND YEAR(date) = ?";
    $types .= "i";
    $params[] = $year;
}

$query .= " GROUP BY YEAR(date), MONTH(date) 
            ORDER BY year DESC, month DESC";

// Prepare and run
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Output results
$sno = 1;
$output = "";

while ($row = mysqli_fetch_assoc($result)) {
    $monthName = date('F', mktime(0, 0, 0, $row['month'], 1));
    $percentage = ($row['total_days'] > 0) ? round(($row['present_days'] / $row['total_days']) * 100, 2) : 0;

    $output .= "<tr>
                    <td>{$sno}</td>
                    <td>{$monthName}</td>
                    <td>{$row['year']}</td>
                    <td>{$row['total_days']}</td>
                    <td>{$row['present_days']}</td>
                    <td><strong>{$percentage}%</strong></td>
                </tr>";
    $sno++;
}

if ($sno == 1) {
    $output .= "<tr><td colspan='6' class='text-center text-muted'>No attendance records found.</td></tr>";
}

echo $output;
?>
