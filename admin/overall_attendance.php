<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

// Get filters with security
$month_filter = isset($_GET['month']) ? mysqli_real_escape_string($connection, $_GET['month']) : date('Y-m');
$department_filter = isset($_GET['department']) ? mysqli_real_escape_string($connection, $_GET['department']) : '';
$year_filter = isset($_GET['year']) ? mysqli_real_escape_string($connection, $_GET['year']) : '';

// Base Query to get student data
$query = "
    SELECT std.sid, std.st_id AS reg_no, std.name, std.department, std.current_year
    FROM students AS std
    WHERE 1
";

// Apply department and year filters
if ($department_filter != '') {
    $query .= " AND std.department = '$department_filter'";
}

if ($year_filter != '') {
    $query .= " AND std.current_year = '$year_filter'";
}

// Execute query
$query_run = mysqli_query($connection, $query);
if (!$query_run) {
    die("Query failed: " . mysqli_error($connection));
}

// Get month and year for the filter dropdown
$departments = mysqli_query($connection, "SELECT DISTINCT department FROM students");
$years = mysqli_query($connection, "SELECT DISTINCT current_year FROM students");

// Calculate Monthly and Overall Attendance for each student
function getMonthlyAttendance($sid, $month_filter) {
    global $connection;
    $start_date = $month_filter . '-01';
    $end_date = $month_filter . '-31';
    
    $query = "SELECT COUNT(*) AS present_days
              FROM attendance 
              WHERE sid = '$sid' 
              AND date BETWEEN '$start_date' AND '$end_date' 
              AND status = 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['present_days'];
}

function getOverallAttendance($sid) {
    global $connection;
    $query = "SELECT date, status 
              FROM attendance 
              WHERE sid = '$sid'";
    $result = mysqli_query($connection, $query);

    $total_days = 0;
    $present_days = 0;
    $previous_was_absent = false;

    while ($row = mysqli_fetch_assoc($result)) {
        $total_days++;
        if ($row['status'] == 1) {
            $present_days++;
            if ($previous_was_absent) {
                // Add 1% for consecutive present after absence
                $present_days++;
                $previous_was_absent = false;
            }
        } else {
            $previous_was_absent = true;
        }
    }

    if ($total_days === 0) {
        return 0; // Or return 'N/A' if preferred
    }

    $attendance_percent = ($present_days / $total_days) * 100;
    return min($attendance_percent, 100); // Do not exceed 100%
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
    margin-top: 10px;
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
.table {
    margin-top: 10px;
}
.table th, .table td {
    word-wrap: break-word;
}
.btn{
    margin-left:10px;
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
        margin-top:60px; 
    }
}

    </style>
</head>
<body style="background-color: #f8f9fa;">
<?php include('sidebar.php'); ?>
<div class="main-content">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <h3>Overall Attendance</h3>

        <form method="GET" class="form-inline">
            <label for="month" class="mr-2 font-weight-bold">Select Month:</label>
            <input type="month" name="month" id="month" class="form-control mr-3" value="<?= $month_filter; ?>">

            <label for="department" class="mr-2 font-weight-bold">Department:</label>
            <select name="department" id="department" class="form-control mr-3">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($departments)) { ?>
                    <option value="<?= $row['department']; ?>" <?= ($row['department'] == $department_filter) ? 'selected' : ''; ?>><?= $row['department']; ?></option>
                <?php } ?>
            </select>

            <label for="year" class="mr-2 font-weight-bold">Year:</label>
            <select name="year" id="year" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($years)) { ?>
                    <option value="<?= $row['current_year']; ?>" <?= ($row['current_year'] == $year_filter) ? 'selected' : ''; ?>><?= $row['current_year']; ?></option>
                <?php } ?>
            </select>

            <button type="submit" class="btn btn-success"><i class="fas fa-filter"></i>Filter</button>
            <?php
$dept = isset($_GET['department']) ? $_GET['department'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
?>
<a class="btn btn-primary" href="over_print.php?department=<?= $dept ?>&year=<?= $year ?>&month=<?= $month ?>" target="_blank"> <i class="fas fa-download"></i>
    Download
</a>
        </form>
    </div>

    <hr>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>SID</th>
                    <th>Name</th>
                    <th>Reg.No</th>
                    <th>Total Hours</th>
                    <th>Days Present</th>
                    <th>Monthly Attendance</th>
                    <th>Overall Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 1;
                $hasData = false;
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $hasData = true;
                    $monthly_attendance = getMonthlyAttendance($row['sid'], $month_filter);
                    $overall_attendance = getOverallAttendance($row['sid']);
                    ?>
                    <tr>
                        <td><?= $sno++; ?></td>
                        <td><?= htmlspecialchars($row['sid']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['reg_no']); ?></td>
                        <td>94 hrs</td>
                        <td><?= $monthly_attendance; ?> days</td>
                        <td><?= number_format($monthly_attendance, 2) . '%'; ?></td>
                        <td><?= number_format($overall_attendance, 2) . '%'; ?></td>
                    </tr>
                <?php } 
                // Show "No Data Available" if no records found
                if (!$hasData) {
                    echo '<tr><td colspan="7" class="text-center text-danger">No Data Available</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
function toggleSidebar() {
        let sidebar = document.querySelector('.sidebar');
        let hmsTitle = document.getElementById('hms-title');
        
        sidebar.classList.toggle('closed');

        if (sidebar.classList.contains('closed')) {
            hmsTitle.style.display = 'none';
        } else {
            hmsTitle.style.display = 'block';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
