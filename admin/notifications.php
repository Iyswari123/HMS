<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    echo json_encode(['count' => 0]);
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = mysqli_query($connection, $query);
$admin = mysqli_fetch_assoc($result);

$aid = $admin['aid'];
$dept = $admin['department'];

$count = 0;

if (strpos($aid, 'A') === 0) {
    // HOD view: faculty-approved requests from same dept
    $query = "
        SELECT COUNT(*) as count 
        FROM outpass_requests o 
        INNER JOIN students s ON o.sid = s.sid 
        WHERE o.fstatus = 'Approved' AND o.astatus = 'Pending' AND s.department = '$dept'
    ";
} elseif (strpos($aid, 'P') === 0)  {
    // Principal view: HOD-approved requests
    $query = "
        SELECT COUNT(*) as count 
        FROM outpass_requests o
        INNER JOIN students s ON o.sid = s.sid 
        WHERE astatus = 'Approved' AND pstatus = 'Pending'
    ";
} else {
    echo json_encode(['count' => 0]);
    exit();
}

$res = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($res);
$count = $row['count'];

echo json_encode(['count' => $count]);
?>
