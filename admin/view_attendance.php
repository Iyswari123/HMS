<?php 
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

// Filters
$date = isset($_GET['date']) ? mysqli_real_escape_string($connection, $_GET['date']) : date('Y-m-d');
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($connection, $_GET['status']) : 'all';
$department_filter = isset($_GET['department']) ? mysqli_real_escape_string($connection, $_GET['department']) : '';
$year_filter = isset($_GET['year']) ? mysqli_real_escape_string($connection, $_GET['year']) : '';

// Dropdown data
$departments = mysqli_query($connection, "SELECT DISTINCT department FROM students");
$years = mysqli_query($connection, "SELECT DISTINCT current_year FROM students");

// Build query
$query = "SELECT std.sid, std.st_id AS reg_no, std.name, std.department, std.current_year, att.status 
          FROM students AS std 
          LEFT JOIN attendance AS att ON std.sid = att.sid AND att.date = '$date' 
          WHERE 1";

if ($status_filter == 'present') {
    $query .= " AND att.status = 1";
} elseif ($status_filter == 'absent') {
    $query .= " AND att.status = 0";
} elseif ($status_filter == 'not_marked') {
    $query .= " AND att.status IS NULL";
}

if (!empty($department_filter)) {
    $query .= " AND std.department = '$department_filter'";
}
if (!empty($year_filter)) {
    $query .= " AND std.current_year = '$year_filter'";
}

$query_run = mysqli_query($connection, $query);
if (!$query_run) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../includes/jquery_latest.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
        }
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
    flex: 1;
    margin-left: 250px;
    margin-top:-14px;
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
.progress {
    height: 24px;
    width: 40%;
    margin: 0 auto; /* This centers the progress bar horizontally */
    display: flex;
    align-items: center; /* Center text vertically */
    justify-content: center; /* Center text horizontally if needed */
}
    .progress-bar.bg-success,
    .progress-bar.bg-danger,
    .progress-bar.bg-warning {
        color: white !important;
}
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;  /* Full width on small screens */
                height: auto;  /* Adjust height */
                position: relative;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 10px;
                margin-top: 40px;
            }
            .progress {
            height: 24px;
            width: 100%;
            margin: 0 auto; /* This centers the progress bar horizontally */
            display: flex;
            align-items: center; /* Center text vertically */
            justify-content: center; /* Center text horizontally if needed */
            }
        }
</style>
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="main-content">
<br>
    <!-- Filter Row with Title -->
    <div class="d-flex flex-wrap align-items-center mb-4">
        <h3 class="mr-4 mb-2">Attendance Records</h3>   
        <form method="GET" class="form-inline flex-wrap justify-content-end ml-auto">
            <label for="date" class="mr-2 font-weight-bold">Date:</label>
            <input type="date" name="date" id="date" class="form-control mr-3 mb-2" value="<?= $date; ?>">

            <label for="status" class="mr-2 font-weight-bold">Status:</label>
            <select name="status" id="status" class="form-control mr-3 mb-2">
                <option value="all" <?= ($status_filter == 'all') ? 'selected' : ''; ?>>All</option>
                <option value="present" <?= ($status_filter == 'present') ? 'selected' : ''; ?>>Present</option>
                <option value="absent" <?= ($status_filter == 'absent') ? 'selected' : ''; ?>>Absent</option>
                <option value="not_marked" <?= ($status_filter == 'not_marked') ? 'selected' : ''; ?>>Not Marked</option>
            </select>

            <label for="department" class="mr-2 font-weight-bold">Department:</label>
            <select name="department" id="department" class="form-control mr-3 mb-2">
                <option value="">All</option>
                <?php mysqli_data_seek($departments, 0); while ($row = mysqli_fetch_assoc($departments)) { ?>
                    <option value="<?= $row['department']; ?>" <?= ($row['department'] == $department_filter) ? 'selected' : ''; ?>>
                        <?= $row['department']; ?>
                    </option>
                <?php } ?>
            </select>

            <label for="year" class="mr-2 font-weight-bold">Year:</label>
            <select name="year" id="year" class="form-control mb-2">
                <option value="">All</option>
                <?php mysqli_data_seek($years, 0); while ($row = mysqli_fetch_assoc($years)) { ?>
                    <option value="<?= $row['current_year']; ?>" <?= ($row['current_year'] == $year_filter) ? 'selected' : ''; ?>>
                        <?= $row['current_year']; ?>
                    </option>
                <?php } ?>
            </select>
        </form>
    </div>
<hr>
    <!-- Attendance Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
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
                $sno = 1;
                $hasData = false;

                while ($row = mysqli_fetch_assoc($query_run)) {
                    $hasData = true;
                    $attendance_status = 'Not Marked';
                    $status_class = 'bg-warning';

                    if ($row['status'] == 1) {
                        $attendance_status = 'Present';
                        $status_class = 'bg-success';
                    } elseif ($row['status'] === "0") {
                        $attendance_status = 'Absent';
                        $status_class = 'bg-danger';
                    }
                ?>
                <tr>
                    <td><?= $sno++; ?></td>
                    <td><?= htmlspecialchars($row['sid']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['reg_no']); ?></td>
                    <td><?= htmlspecialchars($row['department']); ?></td>
                    <td><?= htmlspecialchars($row['current_year']); ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar <?= $status_class; ?>" style="width: 100%;">
                                <?= $attendance_status; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>

                <?php if (!$hasData): ?>
                    <tr><td colspan="7" class="text-center text-danger">No Data Available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#date, #status, #department, #year").change(function(){
        $(this).closest("form").submit(); 
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
