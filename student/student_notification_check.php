<?php
session_start();
include("../includes/dbconn.php"); // unga database connection file include pannanum

$student_id = $_SESSION['student_id']; // session-la student id save panirukano? athu eduthu
$response = ['showDot' => false];

$query = "SELECT final_status FROM outpass_requests WHERE student_id = '$student_id' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $final_status = $row['final_status'];
    if ($final_status == 'Approved' || $final_status == 'Rejected') {
        $response['showDot'] = true;
    }
}

echo json_encode($response);
?>
