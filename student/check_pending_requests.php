<?php
session_start();
include('../includes/dbconn.php');

// Fetch the number of pending requests for the logged-in student
if (isset($_SESSION['sid'])) {
    $sid = $_SESSION['sid'];
    $query = "SELECT COUNT(*) as count FROM outpass_requests WHERE sid = '$sid' AND sstatus = 'Pending' AND tstatus = 'Approved' AND tstatus = 'Rejected' AND fstatus = 'Approved' AND fstatus = 'Rejected' AND astatus = 'Approved' AND astatus = 'Rejected' AND pstatus = 'Approved' AND pstatus = 'Rejected'";
    $res = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($res);
    echo json_encode(['count' => $row['count']]);
} else {
    echo json_encode(['count' => 0]);
}
?>
