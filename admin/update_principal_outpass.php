<?php
include('../includes/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['sid'], $_POST['action'])) {
    $sid = $_POST['sid'];
    $action = $_POST['action'];
    $status = ($action === 'Approved') ? 'Approved' : 'Rejected';

    $query = "UPDATE outpass_requests SET pstatus = '$status' WHERE sid = '$sid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update database."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}

?>

