<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

// Filters
$month = $_GET['month'] ?? date('Y-m');
$department = $_GET['department'] ?? '';
$year = $_GET['year'] ?? '';

// Fetch student data
$query = "SELECT sid, st_id AS reg_no, name, department, current_year FROM students WHERE 1=1";
if ($department) $query .= " AND department = '$department'";
if ($year) $query .= " AND current_year = '$year'";
$result = mysqli_query($connection, $query);

// Store student data
$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance Report</title>
<style>
body {
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.logo {
    width: 110px;
    height: auto;
}

.name {
    width: 510px;
    height: auto;
}
h2, h4 {
    text-align: center;
    margin: 5px 0;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}
th, td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #f2f2f2;
}

.print-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1cm;
}

/* Default (screen view) */
.signature-footer {
    margin-top: 100px;
    width: 100%;
    text-align: center;
    font-size: 15px;
    position: static; /* remove fixed positioning for screen */
}

        @media print {
            .print-btn {
                display: none;
            }
            @page {
        margin: 0;
    }
    body {
        margin: 1cm;
    }
.print-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1cm;
}

    .signature-footer {
        /* Remove fixed positioning */
        position: static;
        bottom: auto;
        left: auto;
        width: 100%;
        text-align: center;
        font-size: 15px;
        page-break-before: avoid; /* Avoid breaking just before */
    }

    .signature-footer table {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        border: 1px solid #ccc;
    }

    .signature-footer td {
        padding-top: 30px;
        vertical-align: bottom;
        border: 1px solid #ccc;
    }
        }

    </style>
</head>
<body>

<!-- Print button top-left -->
<div class="print-btn">
    <button onclick="window.print()">🖨️ Print</button>
</div>

<div class="header">
    <img src="../images/college_logo.jpg" class="logo" alt="College Logo">
    <img src="../images/college_name.png" class="name" alt="College Name">
</div>

<h2>Attendance Report - <?= date('F Y', strtotime($month)) ?></h2>
<h4>Department: <?= $department ?: 'All' ?> | Year: <?= $year ?: 'All' ?></h4>

<table>
    <thead>
        <tr>
            <th>S.No</th>
            <th>SID</th>
            <th>Name</th>
            <th>Reg.No</th>
            <th>Monthly Attendance</th>
            <th>Overall Attendance</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($students) === 0): ?>
            <tr><td colspan="6" style="color:red;">No Data Available</td></tr>
        <?php else: ?>
            <?php $i = 1; foreach ($students as $stu): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($stu['sid']) ?></td>
                    <td><?= htmlspecialchars($stu['name']) ?></td>
                    <td><?= htmlspecialchars($stu['reg_no']) ?></td>
                    <td><?= number_format(getMonthlyAttendance($stu['sid'], $month)) ?> %</td>
                    <td><?= number_format(getOverallAttendance($stu['sid']), 2) ?> %</td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="pdf-button">
    <form action="generate_pdf.php" method="GET">
        <input type="hidden" name="month" value="<?= $month ?>">
        <input type="hidden" name="department" value="<?= $department ?>">
        <input type="hidden" name="year" value="<?= $year ?>">
    </form>
</div>

</body>
<div class="signature-footer">
    <table>
        <tr>
            <td>
                ___________________________<br><br>
                <strong>RT</strong>
            </td>
            <td>
                ___________________________<br>
                <strong>HOD</strong><br>
                Dr. Alaaudeen K M
            </td>
            <td>
                ___________________________<br>
                <strong>Principal</strong><br>
                Dr. Richard
            </td>
        </tr>
    </table>
</div>


</html>

<?php
// Attendance functions
function getMonthlyAttendance($sid, $month) {
    global $connection;
    $start = $month . '-01';
    $end = $month . '-31';
    $q = "SELECT COUNT(*) as present FROM attendance WHERE sid = '$sid' AND date BETWEEN '$start' AND '$end' AND status = 1";
    $r = mysqli_query($connection, $q);
    $data = mysqli_fetch_assoc($r);
    return $data['present'];
}

function getOverallAttendance($sid) {
    global $connection;
    $q = "SELECT date, status FROM attendance WHERE sid = '$sid'";
    $r = mysqli_query($connection, $q);
    $total = 0; $present = 0; $absent_before = false;
    while ($row = mysqli_fetch_assoc($r)) {
        $total++;
        if ($row['status'] == 1) {
            $present++;
            if ($absent_before) {
                $present++; // Bonus for previous day
                $absent_before = false;
            }
        } else {
            $absent_before = true;
        }
    }
    return ($total > 0) ? min(($present / $total) * 100, 100) : 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['print_outpass'])) {
        echo "<script>window.print();</script>";
    } elseif (isset($_POST['save_file'])) {
        // Save logic placeholder (like log to DB or text file)
        file_put_contents('saved_attendance_log.txt', "Saved report for month: $month, department: $department, year: $year\n", FILE_APPEND);
        echo "<script>alert('File saved successfully');</script>";
    }
}
?>
