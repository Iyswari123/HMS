<?php 
session_start();
if(isset($_SESSION['email'])) {
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
    body {
        background-color: #f8f9fa;
    }
    .wrapper {
        display: flex;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .container {
        margin-left: 200px;
        width: calc(100% - 230px);
    }
    @media (max-width: 768px) {
        .topbar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .container {
            margin-left: 0;
            width: 100%;
        }
        .container {
            margin-top: -2rem !important;
        }
        .mobile-scroll-table {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-scroll-table table {
            min-width: 600px;
            width: 100%;
        }
        #attendanceForm {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding: 0 10px;
        gap: 15px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    #attendanceForm .form-group {
        width: 100%;
    }

    #attendanceForm label {
        margin-bottom: 5px;
        font-weight: 500;
        text-align: left;
    }

    .form-control {
        width: 100%;
    }
    .progress {
        align-items: center;
        margin-left: 50px;
        height: 24px;
        width: 80px;
    }
    .progress-bar.bg-success,
    .progress-bar.bg-danger,
    .progress-bar.bg-warning {
        color: white !important;
    }
    }
    .progress {
        margin-left: 50px;
        height: 24px;
        width: 80px;
    }
    .progress-bar.bg-success,
    .progress-bar.bg-danger,
    .progress-bar.bg-warning {
        color: white !important;
    }
</style>
<?php include('topbar.php'); ?>
<br><br>
<div class="container mt-5" style="max-width: 1140px;">
    <!-- Heading -->
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="mb-0">Attendance Records</h4>
    </div>

    <br>

    <!-- Top Row: Date, Department, Year -->
    <form method="GET" id="attendanceForm">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="date">Select Date:</label>
            <input type="date" name="date" id="date" class="form-control"
                value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>">
        </div>

        <div class="form-group col-md-3">
            <label for="department">Department:</label>
            <select name="department" id="department" class="form-control">
                <option value="">All</option>
                <?php 
                $departments = ['CSE', 'ECE', 'EEE', 'CIVIL', 'AI&DS', 'MECH'];
                foreach ($departments as $dept) {
                    $selected = (isset($_GET['department']) && $_GET['department'] == $dept) ? 'selected' : '';
                    echo "<option value=\"$dept\" $selected>$dept</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="year">Year:</label>
            <select name="year" id="year" class="form-control">
                <option value="">All</option>
                <?php 
                $years = ['I', 'II', 'III', 'IV'];
                foreach ($years as $yr) {
                    $selected = (isset($_GET['year']) && $_GET['year'] == $yr) ? 'selected' : '';
                    echo "<option value=\"$yr\" $selected>$yr</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="all" <?php echo (!isset($_GET['status']) || $_GET['status'] == 'all') ? 'selected' : ''; ?>>All</option>
                <option value="present" <?php echo (isset($_GET['status']) && $_GET['status'] == 'present') ? 'selected' : ''; ?>>Present</option>
                <option value="absent" <?php echo (isset($_GET['status']) && $_GET['status'] == 'absent') ? 'selected' : ''; ?>>Absent</option>
                <option value="notmarked" <?php echo (isset($_GET['status']) && $_GET['status'] == 'notmarked') ? 'selected' : ''; ?>>Not Marked</option>
            </select>
        </div>
    </div>
    <hr>
</form>

</div>

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
                    <th>Attendance Status</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                include('../includes/dbconn.php');
                $rid = mysqli_real_escape_string($connection, $_SESSION['rid']);

                $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
                $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
                $department = isset($_GET['department']) ? mysqli_real_escape_string($connection, $_GET['department']) : '';
                $year = isset($_GET['year']) ? mysqli_real_escape_string($connection, $_GET['year']) : '';

                $attendance_query = "SELECT sid, status FROM attendance WHERE date = '$date'";
                $attendance_result = mysqli_query($connection, $attendance_query);
                $attendance_data = [];
                while ($att_row = mysqli_fetch_assoc($attendance_result)) {
                    $attendance_data[$att_row['sid']] = $att_row['status'];
                }

                $query = "
                SELECT 
                    std.sid AS sid, 
                    std.st_id AS reg_no, 
                    std.name AS name, 
                    std.department AS department, 
                    std.current_year AS current_year 
                FROM students AS std
                INNER JOIN teachers AS tech 
                    ON tech.gender = std.gender
                WHERE tech.rid = '$rid'";

                if (!empty($department)) {
                    $query .= " AND std.department = '$department'";
                }
                if (!empty($year)) {
                    $query .= " AND std.current_year = '$year'";
                }

                $query .= " ORDER BY std.sid ASC";

                $query_run = mysqli_query($connection, $query);
                $sno = 1;
                $has_data = false;

                while ($row = mysqli_fetch_assoc($query_run)) {
                    $sid = $row['sid'];

                    if (isset($attendance_data[$sid])) {
                        $attendance_status = $attendance_data[$sid] == 1 ? 'Present' : 'Absent';
                        $status_class = $attendance_data[$sid] == 1 ? 'bg-success' : 'bg-danger';
                    } else {
                        $attendance_status = 'Not Marked';
                        $status_class = 'bg-warning';
                    }

                    if ($status_filter == 'present' && $attendance_status != 'Present') continue;
                    if ($status_filter == 'absent' && $attendance_status != 'Absent') continue;
                    if ($status_filter == 'notmarked' && $attendance_status != 'Not Marked') continue;

                    $has_data = true;
            ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo htmlspecialchars($row['sid']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['reg_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td><?php echo htmlspecialchars($row['current_year']); ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar <?php echo $status_class; ?>" style="width: 100%;">
                                <?php echo $attendance_status; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php 
                }

                if (!$has_data) {
                    echo '<tr><td colspan="7" class="text-center text-danger">No data available</td></tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#date, #status, #department, #year").change(function(){
            $("#attendanceForm").submit();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<?php 
} else {
  header('Location:index1.php');
}
?>
