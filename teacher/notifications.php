<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    echo json_encode(['count' => 0]);
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM teachers WHERE email = '$email'";
$result = mysqli_query($connection, $query);
$teacher = mysqli_fetch_assoc($result);

$rid = $teacher['rid'];
$gender = $teacher['gender'];

$count = 0;

if (strpos($rid, 'R') === 0) {
    // HOD view: RT-approved requests from same dept
    $query = "
        SELECT COUNT(*) as count 
        FROM outpass_requests o 
        INNER JOIN students s ON o.sid = s.sid 
        WHERE  o.sstatus = 'Pending' AND s.gender = '$gender'
    ";
} elseif (strpos($rid, 'F') === 0)  {
    // Principal view: Faculty-approved requests
    $query = "
        SELECT COUNT(*) as count 
        FROM outpass_requests o
        INNER JOIN students s ON o.sid = s.sid 
        WHERE tstatus = 'Approved' AND fstatus = 'Pending'
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
