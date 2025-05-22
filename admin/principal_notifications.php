<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    echo json_encode(['newRequests' => 0]);
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = mysqli_query($connection, $query);
$admin = mysqli_fetch_assoc($result);

$aid = $admin['aid'];

// Check if the user is a Principal
$isPrincipal = strpos($aid, 'P') === 0;

if ($isPrincipal) {
    // Fetch pending requests for Principal's approval
    $query = "
        SELECT COUNT(*) AS total
        FROM outpass_requests o
        WHERE o.astatus = 'Approved' 
        AND o.sstatus = 'Pending' 
        AND o.pstatus = 'Pending'
        AND o.leave_date >= CURDATE()
    ";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $newRequests = $row['total'];

    echo json_encode(['newRequests' => $newRequests]);
} else {
    echo json_encode(['newRequests' => 0]);
}
?>
