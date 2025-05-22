<?php
include('../includes/dbconn.php');

if (isset($_POST['sid']) && isset($_POST['status'])) {
    $sid = mysqli_real_escape_string($connection, $_POST['sid']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $date = date('Y-m-d');

    // Update or insert attendance status
    $query = "INSERT INTO attendance (sid, date, status) 
              VALUES ('$sid', '$date', '$status') 
              ON DUPLICATE KEY UPDATE status = '$status'"; // Update if already marked
    
    if (mysqli_query($connection, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
