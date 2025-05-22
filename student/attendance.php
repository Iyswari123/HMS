<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index2.php');
    exit();
}

include('../includes/dbconn.php');

$email = mysqli_real_escape_string($connection, $_SESSION['email']);

// Fetch student details
$query = "SELECT sid, name FROM students WHERE email = '$email'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 0) {
    session_destroy();
    header('Location: index.php');
    exit();
}

$student = mysqli_fetch_assoc($result);
$sid = $student['sid'];
$name = $student['name'];
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
    th { text-transform: uppercase; }
    td { vertical-align: middle; }
    a.btn:hover {
        background-color: #5a5a6e;
        border-color: #343a40;
    }
    .wrapper {
        display: flex;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 10px;
        margin-top: 30px;
    }
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
            margin-top: 0px;
        }
        .th { text-transform: uppercase; }
        .td { vertical-align: middle; }
        .mobile-scroll-table {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .mobile-scroll-table table {
            min-width: 600px;
            width: 100%;
        }
        .filter-form {
            flex-direction: column;
            align-items: center;
        }
        .filter-form select,
        .filter-form button {
            width: 50% !important;
            margin-bottom: 20px;
            margin-left: 20px;
        }
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px;
        text-align: center;
        white-space: nowrap;
    }
</style>

<?php include('topbar.php'); ?>

<div class="main-content">
<div class="container mt-5">
    <h4 class="mt-3">
        <span style="color: black; font-weight: bold;">Report: </span> 
        <span style="color: #007bff; font-weight: bold;">
            <?php echo htmlspecialchars($name); ?> (ID: <?php echo htmlspecialchars($sid); ?>)
        </span>
    </h4>

    <!-- Search Filters -->
    <form id="filterForm" class="form-inline justify-content-end mb-3">
        <select name="month" id="filterMonth" class="form-control form-control-sm mr-2" style="width: 150px;">
            <option value="">All Months</option>
            <?php
            $months = ["January", "February", "March", "April", "May", "June", 
                       "July", "August", "September", "October", "November", "December"];
            foreach ($months as $m) {
                echo "<option value='$m'>$m</option>";
            }
            ?>
        </select>

        <select name="year" id="filterYear" class="form-control form-control-sm mr-2" style="width: 120px;">
            <option value="">All Years</option>
            <?php
            for ($y = 2022; $y <= date('Y'); $y++) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </form>

    <hr>

    <!-- Attendance Table -->
    <div class="mobile-scroll-table">
        <table class="table table-striped mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Month</th>
                    <th scope="col">Year</th>
                    <th scope="col">Total Days</th>
                    <th scope="col">Present Days</th>
                    <th scope="col">Attendance Percentage</th>
                </tr>
            </thead>
            <tbody id="attendanceTable">
                <!-- Data will be loaded here dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    function fetchAttendance(month = '', year = '') {
        $.ajax({
            url: "fetch_attendance.php",
            type: "POST",
            data: {
                sid: "<?php echo $sid; ?>",
                month: month,
                year: year
            },
            success: function(data) {
                $("#attendanceTable").html(data);
            }
        });
    }

    fetchAttendance(); // Load all records initially

    $("#filterForm").submit(function(e) {
        e.preventDefault();
        let month = $("#filterMonth").val();
        let year = $("#filterYear").val();
        fetchAttendance(month, year);
    });
});
</script>

</body>
</html>