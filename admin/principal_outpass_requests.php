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

$isPrincipal = strpos($aid, 'P') === 0;

if (!$isPrincipal) {
    echo "<script>alert('Access denied! Only Principal can access this page.'); window.location.href='plogin.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sid']) && isset($_POST['action'])) {
    $sid = $_POST['sid'];
    $action = $_POST['action'];

    $status = ($action === 'approve') ? 'Approved' : 'Rejected';
    $update = "UPDATE outpass_requests SET pstatus = '$status' WHERE sid = '$sid'";
    mysqli_query($connection, $update);
}

// Fetch outpass requests with approved status by faculty and department-wise for the Principal
$query = "
    SELECT o.sid, s.name, s.department, s.current_year,
           o.reason, o.leave_date, o.return_date, o.destination,
           o.tstatus, o.fstatus, o.astatus, o.sstatus, o.pstatus
    FROM outpass_requests o
    INNER JOIN students s ON o.sid = s.sid
    WHERE o.astatus = 'Approved' 
    AND o.leave_date <= CURDATE()  -- Ensure leave date is in the future
    ORDER BY s.department, o.leave_date DESC
";

$result = mysqli_query($connection, $query);
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
.table th,
    .table td {
        padding: 4px 6px !important;
        font-size: 15px;
        vertical-align: middle;
    }

    .table {
        table-layout: fixed;
    }

    .table th:nth-child(1), .table td:nth-child(1) { width: 40px; }  /* S.No */
    .table th:nth-child(2), .table td:nth-child(2) { width: 70px; }  /* SID */
    .table th:nth-child(3), .table td:nth-child(3) { width: 100px; } /* Name */
    .table th, .table td {
        word-wrap: break-word;
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
    .table th,
    .table td {
        padding: 4px 6px !important;
        font-size: 15px;
        vertical-align: middle;
    }

    .table {
        table-layout: fixed;
    }

    .table th:nth-child(1), .table td:nth-child(1) { width: 40px; }  /* S.No */
    .table th:nth-child(2), .table td:nth-child(2) { width: 70px; }  /* SID */
    .table th:nth-child(3), .table td:nth-child(3) { width: 100px; } /* Name */
    
    .table th:nth-child(4), .table td:nth-child(4) { width: 70px; }  
    .table th:nth-child(5), .table td:nth-child(5) { width: 70px; }  
    .table th:nth-child(6), .table td:nth-child(6) { width: 100px; } 
    
    .table th:nth-child(7), .table td:nth-child(7) { width: 100px; } 
    .table th:nth-child(8), .table td:nth-child(8) { width: 100px; }  
    .table th:nth-child(9), .table td:nth-child(9) { width: 100px; } 
    
    .table th:nth-child(10), .table td:nth-child(10) { width: 100px; }  
    .table th:nth-child(11), .table td:nth-child(11) { width: 100px; }  
    
    .table th:nth-child(12), .table td:nth-child(12) { width: 100px; }  /* S.No */
    .table th:nth-child(13), .table td:nth-child(13) { width: 100px; } /* Name */

    .table th, .table td {
        word-wrap: break-word;
    }
}
</style>
<?php include('sidebar.php'); ?>
<br>
<div class="main-content">
    <h4>Welcome, <?php echo $name; ?></h4>
    <div class="alert alert-info text-center">This page is for: <strong>Principal</strong></div>
    <hr>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="mobile-scroll-table">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>S.N</th>
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
                    <th>Principal Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sno = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $pstatus = $row['pstatus'];
                    $sid = $row['sid'];

                    // Badge class for principal status
                    $pBadge = 'badge badge-secondary';
                    if ($pstatus == 'Approved') $pBadge = 'badge badge-success';
                    elseif ($pstatus == 'Rejected') $pBadge = 'badge badge-danger';

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
                        <td><span class='badge badge-success'>{$row['astatus']}</span></td>
                        <td><span class='{$pBadge}' id='pstatus_$sid'>{$pstatus}</span></td>
                        <td>";
                        if ($pstatus == 'Pending') {
                            echo "<button class='btn btn-success btn-sm action-btn' data-sid='{$sid}' data-action='Approved'>✔</button>
                                  <button class='btn btn-danger btn-sm action-btn' data-sid='{$sid}' data-action='Rejected'>❌</button>";
                        } else {
                            if ($pstatus == 'Approved') {
                                echo "<a href='../print_outpass.php?sid={$sid}' target='_blank' class='btn btn-primary btn-sm'>🖨️ Print</a>";
                            } else {
                                echo "<span class='text-muted'>Decision Made</span>";
                            }
                        }
                        

                    echo "</td></tr>";
                    $sno++;
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-danger">No outpass requests.</p>
    <?php endif; ?>
</div>

<!-- Include jQuery at the top of your script if not included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $(".action-btn").click(function() {
        var button = $(this);
        var sid = button.data("sid");
        var action = button.data("action");

        $.ajax({
            url: "update_principal_outpass.php",
            type: "POST",
            data: { sid: sid, action: action }, // action instead of astatus
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    var badgeClass = (action === "Approved") ? "badge badge-success" : "badge badge-danger";
                    $("#pstatus_" + sid)
                        .removeClass()
                        .addClass(badgeClass)
                        .text(action);

                    var rowActions = $("#row_" + sid + " td:last");
                    rowActions.empty();

                    if (action === "Approved") {
                        rowActions.append(
                            "<a href='../print_outpass.php?sid=" + sid + "&duplicate=true' target='_blank' class='btn btn-primary btn-sm'>🖨️ Print</a>"
                        );
                    } else {
                        rowActions.append("<span class='text-muted'>Decision Made</span>");
                    }

                    alert("Status updated to " + action + "!");
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


if (response.status === "success") {
    var badge = (pstatus === "Approved") ? "badge badge-success" : "badge badge-danger";
    $("#pstatus_" + sid).attr("class", badge).text(pstatus);
    
    // Replace action buttons with print button
    $("#row_" + sid + " td:last").html("<a href='print_outpass.php?sid=" + sid + "' target='_blank' class='btn btn-primary btn-sm'>🖨️ Print</a>");
}

</script>

</body>
</html>

