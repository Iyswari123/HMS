<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = mysqli_query($connection, $query);
$admin = mysqli_fetch_assoc($result);

$aid = $admin['aid'];
$name = $admin['name'];
$dept = $admin['department'];

$isPrincipal = strpos($aid, 'P') === 0;
$isHOD = strpos($aid, 'A') === 0;

if (!$isHOD && !$isPrincipal) {
    die("Access Denied");
}
$roleLabel = $isHOD ? "Principal" : "HOD";

// HOD only should access this
if (strpos($aid, 'A') !== 0) {
    echo "<script>alert('Access denied! Only HOD can access this page.'); window.location.href='alogin.php';</script>";
    exit();
}

$showRequests = $isHOD; // Only show requests if it's HOD

if ($showRequests) {
    $query = "
        SELECT o.sid, s.name, s.department, s.current_year,
               o.reason, o.leave_date, o.return_date, o.destination,
               o.tstatus, o.fstatus, o.astatus, o.sstatus
        FROM outpass_requests o
        INNER JOIN students s ON o.sid = s.sid
        WHERE o.fstatus = 'Approved'  AND o.leave_date >= CURDATE() AND s.department = '$dept'
        ORDER BY o.leave_date DESC
    ";
    $result = mysqli_query($connection, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../includes/jquery_latest.js"></script>
    <title>HMS</title>
</head>
<body style="background-color: #f8f9fa;">
<style>
/* Base Layout */
.sidebar {
    width: 250px;
    background-color: #343a40;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    transition: transform 0.3s ease-in-out;
    z-index: 1000;
}

.main-content {
    margin-left: 250px;
    margin-top: -14px;
    padding: 20px;
    transition: margin-left 0.3s ease;
}

.sidebar.closed ~ .main-content {
    margin-left: 60px;
}
/* Sidebar Collapse */
.sidebar.closed {
    width: 60px;
}

.sidebar.closed a {
    font-size: 0;
}

.sidebar.closed a i {
    font-size: 18px;
}

.sidebar.closed #hms-title {
    display: none;
}
@media (max-width: 768px) {
            .sidebar {
        width: 100%;  /* Full width on small screens */
        height: auto;  /* Adjust height */
        position: relative;
    }
    .main-content {
        margin-left: 0;  /* Remove left margin */
        width: 100%;  /* Take full width */
        padding: 10px;  /* Add spacing */
        margin-top: 40px; 
    }
    .mobile-scroll-table {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .mobile-scroll-table table {
        min-width: 600px; /* Or set to whatever minimum width your table needs */
        width: 100%;
    }
}
</style>
<?php include('sidebar.php'); ?>
<br>
<div class="main-content">
<div class="">
    <h4>Welcome, <?php echo $name; ?></h4>
    <div class="alert alert-info text-center">This page is for: <strong>HOD</strong></div>
<hr>
    <?php if ($isPrincipal): ?>
        <p class="text-center text-danger">You are logged in as HOD, No data to show on this page.</p>
    <?php elseif ($showRequests && mysqli_num_rows($result) > 0): ?>
        <div class="mobile-scroll-table">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>SID</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <th>Reason</th>
                    <th>Leave</th>
                    <th>Return</th>
                    <th>Destination</th>
                    <th>RT Status</th>
                    <th>Faculty Status</th>
                    <th>HOD Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sno = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $astatus = $row['astatus'];
$sid = $row['sid'];

// Badge class for faculty status
$aBadge = 'badge badge-secondary';
if ($astatus == 'Approved') $aBadge = 'badge badge-success';
elseif ($astatus == 'Rejected') $aBadge = 'badge badge-danger';

echo "<tr id='row_$sid'>
    <td>{$sno}</td>
    <td>{$row['sid']}</td>
    <td>{$row['name']}</td>
    <td>{$row['department']}</td>
    <td>{$row['reason']}</td>
    <td>{$row['leave_date']}</td>
    <td>{$row['return_date']}</td>
    <td>{$row['destination']}</td>
    <td><span class='badge badge-success'>{$row['tstatus']}</span></td>
    <td><span class='badge badge-success'>{$row['fstatus']}</span></td>
    <td><span class='{$aBadge}' id='astatus_$sid'>{$astatus}</span></td>
    <td>";

if ($astatus == 'Pending' || $astatus == NULL || $astatus == '') {
    echo "<div class='d-flex justify-content-center gap-1'>
          <button class='btn btn-success btn-sm action-btn' data-sid='{$sid}' data-action='Approved'>Approve</button>
          <button class='btn btn-danger btn-sm action-btn' data-sid='{$sid}' data-action='Rejected'>Reject</button>
          </div>";
} else {
    echo "<span class='text-muted'>Decision Made</span>";
}

echo "</td></tr>";
$sno++;

                } ?>
            </tbody>
        </table>
    <?php elseif ($showRequests): ?>
        <p class="text-center text-danger">No outpass requests</p>
    <?php endif; ?>
</div>
</div>
<!-- Include jQuery at the top of your script if not included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $(".action-btn").click(function(){
        var sid = $(this).data("sid");
        var astatus = $(this).data("action"); // ✅ Fix: use 'astatus' not 'fstatus'
        $('.approve-btn').click(function() {
    let requestId = $(this).data('id');
    updateStatus(requestId, 'Approved');
});

$('.reject-btn').click(function() {
    let requestId = $(this).data('id');
    updateStatus(requestId, 'Rejected');
});
        $.ajax({
            url: "update_admin_outpass.php",
            type: "POST",
            data: { sid: sid, astatus: astatus },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    alert("Outpass Status Updated!");
                    var badge = (astatus === "Approved") ? "badge badge-success" : "badge badge-danger";
                    $("#astatus_" + sid).attr("class", badge).text(astatus);
                    $("#row_" + sid + " .action-btn").remove(); // remove buttons
                    $("#row_" + sid + " td:last").append("<span class='text-muted'>Decision Made</span>");
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX Error: " + error);
            }
        });
    });
});
</script>

</body>
</html>
