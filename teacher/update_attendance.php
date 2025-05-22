<?php
include('../includes/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sid = isset($_POST['sid']) ? trim($_POST['sid']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';

    if (empty($sid) || empty($date) || ($status !== "1" && $status !== "0")) {
        echo "Invalid input.";
        exit();
    }

    // Update attendance status for selected date
    $query = "UPDATE attendance SET status = ? WHERE sid = ? AND date = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sss", $status, $sid, $date);

    if (mysqli_stmt_execute($stmt)) {
        echo "Attendance updated successfully!";
    } else {
        echo "Error updating attendance.";
    }
}
?>
