<?php 
session_start();
if(isset($_SESSION['email'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="../includes/jquery_latest.js"></script>
    <title>HMS</title>
</head>
<body style="background-color: #f8f9fa;">
<style>
@media (max-width: 768px) {
    .topbar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 10px;
    }
    .mobile-scroll-table {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .header-container {
        flex-direction: column;
        align-items: flex-start;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .header-container h4 {
        font-size: 25px;
    }

    .header-container span {
        padding:13px;
        font-size: 15px;
    }
    .mobile-scroll-table table {
        min-width: 600px;
        width: 100%;
    }
    .attendance-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .attendance-actions .btn {
        width: 30px;
        font-size: 12px;
        padding: 5px 0;
    }
}
.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}
.header-container h4 {
    margin: 0;
}
.topbar {
    z-index: 9999;
    position: relative;
}
</style>

<?php include('topbar.php'); ?>

<div class="container mt-3">
    <div class="header-container">
        <h4>Mark Today's Attendance</h4>
        <span>Date: <?php echo date('d-m-Y'); ?></span>
    </div>
    <hr>

    <!-- Filter Form -->
   <!-- Unified Search + Filter Bar -->
<form method="GET" class="mb-3">
    <div class="row no-gutters">

        <div class="col-md-5 pr-2">
            <label class="font-weight-bold">Department</label>
            <select name="department" class="form-control">
                <option value="">All</option>
                <option value="CSE" <?php if(isset($_GET['department']) && $_GET['department']=='CSE') echo 'selected'; ?>>CSE</option>
                <option value="ECE" <?php if(isset($_GET['department']) && $_GET['department']=='ECE') echo 'selected'; ?>>ECE</option>
                <option value="EEE" <?php if(isset($_GET['department']) && $_GET['department']=='EEE') echo 'selected'; ?>>EEE</option>
                <option value="CIVIL" <?php if(isset($_GET['department']) && $_GET['department']=='CIVIL') echo 'selected'; ?>>CIVIL</option>
                <option value="AI&DS" <?php if(isset($_GET['department']) && $_GET['department']=='AI&DS') echo 'selected'; ?>>AI&DS</option>
                <option value="MECH" <?php if(isset($_GET['department']) && $_GET['department']=='MECH') echo 'selected'; ?>>MECH</option>
            </select>
        </div>

        <div class="col-md-5 pr-2">
            <label class="font-weight-bold">Year</label>
            <select name="year" class="form-control">
                <option value="">All</option>
                <option value="I" <?php if(isset($_GET['year']) && $_GET['year']=='I') echo 'selected'; ?>>I</option>
                <option value="II" <?php if(isset($_GET['year']) && $_GET['year']=='II') echo 'selected'; ?>>II</option>
                <option value="III" <?php if(isset($_GET['year']) && $_GET['year']=='III') echo 'selected'; ?>>III</option>
                <option value="IV" <?php if(isset($_GET['year']) && $_GET['year']=='IV') echo 'selected'; ?>>IV</option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>

    <div class="row justify-content-center">
        <?php 
        include('../includes/dbconn.php');
        $rid = mysqli_real_escape_string($connection, $_SESSION['rid']);

        $department = isset($_GET['department']) ? mysqli_real_escape_string($connection, $_GET['department']) : '';
        $year = isset($_GET['year']) ? mysqli_real_escape_string($connection, $_GET['year']) : '';

        $query = "SELECT std.sid, std.st_id AS reg_no, std.name, std.department, std.current_year 
                  FROM students AS std 
                  INNER JOIN teachers AS tech ON tech.gender = std.gender 
                  WHERE tech.rid = '$rid'";

        if (!empty($department)) {
            $query .= " AND std.department = '$department'";
        }
        if (!empty($year)) {
            $query .= " AND std.current_year = '$year'";
        }

        $query_run = mysqli_query($connection, $query);
        if (!$query_run) {
            die("Query failed: " . mysqli_error($connection));
        }
        ?>
        <div class="container mt-1">
            <div class="mobile-scroll-table">
                <table class="table table-striped mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Reg.No</th>
                            <th>Dept</th>
                            <th>Year</th>
                            <th>Attendance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
    $sno = 1;
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $sid = mysqli_real_escape_string($connection, $row['sid']);
            $date = date('Y-m-d');

            $query1 = "SELECT status FROM attendance WHERE sid = '$sid' AND date = '$date'";
            $query_run1 = mysqli_query($connection, $query1);
            $attendance_status = 'Not Marked';
            
            if ($query_run1 && mysqli_num_rows($query_run1) > 0) {
                $attendance_data = mysqli_fetch_assoc($query_run1);
                $attendance_status = $attendance_data['status'] == 1 ? 'Present' : 'Absent';
            }
    ?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo htmlspecialchars($row['sid']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['reg_no']); ?></td>
        <td><?php echo htmlspecialchars($row['department']); ?></td>
        <td><?php echo htmlspecialchars($row['current_year']); ?></td>
        <td class="attendance-status">
    <?php if ($attendance_status == 'Not Marked') { ?>
        <button class="btn btn-success btn-sm mark-attendance" data-sid="<?php echo $row['sid']; ?>" data-status="1">Present</button>
        <button class="btn btn-danger btn-sm mark-attendance" data-sid="<?php echo $row['sid']; ?>" data-status="0">Absent</button>
    <?php } else { 
        echo $attendance_status; 
    } ?>
</td>

        <td>
            <a href="edit_attendance.php?sid=<?php echo $row['sid']; ?>" class="btn btn-primary btn-sm">E</a>
        </td>
    </tr>
    <?php 
        } // end while
    } else {
        echo '<tr><td colspan="8" class="text-center">No data found</td></tr>';
    }
    ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Listen for click events on the "Present" and "Absent" buttons
    $('.mark-attendance').click(function(e) {
        e.preventDefault(); // Prevent page reload and scrolling to the top
        
        var sid = $(this).data('sid'); // Get the student ID from the button's data
        var status = $(this).data('status'); // Get the attendance status (1 for Present, 0 for Absent)

        // Send AJAX request to update the attendance status
        $.ajax({
            url: 'mark_attendance.php', // PHP file that processes the attendance update
            method: 'POST',
            data: {
                sid: sid, // Send student ID
                status: status // Send attendance status
            },
            success: function(response) {
                if (response == 'success') {
                    // Update the attendance status text in the current row
                    var statusText = (status == 1) ? 'Present' : 'Absent';

                    // Find the status cell in the same row and update the text
                    var row = $(this).closest('tr');
                    row.find('.attendance-status').text(statusText);

                    // Optionally, disable the buttons after marking attendance to prevent multiple submissions
                    row.find('.mark-attendance').prop('disabled', true);
                } else {
                    alert('Error updating attendance.');
                }
            }.bind(this) // Bind the "this" keyword to the current button context
        });
    });
});
</script>


</body>
</html>
<?php } else { header('Location:../index.php'); } ?> 
