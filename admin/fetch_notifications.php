<?php
include('../includes/dbconn.php');
$result = mysqli_query($connection, "SELECT * FROM notifications WHERE status='unread' ORDER BY created_at DESC LIMIT 10");

$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}

echo json_encode($notifications);
?>
