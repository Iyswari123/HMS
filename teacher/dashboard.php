<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:index1.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="../includes/jquery_latest.js"></script>

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
        font-size: 15px;
    }
    .mobile-scroll-table {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .mobile-scroll-table table {
        min-width: 800px;
        width: 100%;
    }
    .welcome-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
        margin-bottom: 15px;
    }

    .welcome-header h4 {
        font-size: 16px;
        margin: 0;
    }

    .welcome-header .date {
        font-size: 14px;
        color: #666;
    }
    }
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    .topbar {
        z-index: 9999;
        position: relative;
    }
</style>
</head>
<body style="background-color: #f8f9fa;">

<?php include('topbar.php'); ?>
<div class="container mt-3">

    <?php
    include('../includes/dbconn.php');
    $rid = mysqli_real_escape_string($connection, $_SESSION['rid']);

    // Get teacher's gender
    $gender_query = mysqli_query($connection, "SELECT gender FROM teachers WHERE rid = '$rid'");
    $gender_row = mysqli_fetch_assoc($gender_query);
    $teacher_gender = $gender_row['gender'] ?? '';

    $search = mysqli_real_escape_string($connection, $_GET['search'] ?? '');
    $dept = mysqli_real_escape_string($connection, $_GET['department'] ?? '');
    $year = mysqli_real_escape_string($connection, $_GET['year'] ?? '');

    // Main query with filters
    $query = "SELECT st_id AS reg_no, name, department, email, joining_year, current_year, address, mobile 
              FROM students 
              WHERE LOWER(gender) = LOWER('$teacher_gender')";

    if (!empty($search)) $query .= " AND name LIKE '%$search%'";
    if (!empty($dept)) $query .= " AND department = '$dept'";
    if (!empty($year)) $query .= " AND current_year = '$year'";

    $result = mysqli_query($connection, $query);
    ?>

    <div class="header-container">
        <h4>Welcome Staff ID: <?php echo htmlspecialchars($rid); ?></h4>
        <span>Date: <?php echo date('d-m-Y'); ?></span>
    </div>

    <hr>

    <!-- Search and Filters -->
<!-- Search and Filters -->
<form method="GET" class="mb-4">
    <div class="form-row align-items-end">
        <div class="form-group col-md-3 mb-0">
            <label for="search" class="font-weight-bold">Student Name</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Search Name" value="<?php echo $search; ?>">
        </div>

        <div class="form-group col-md-3 mb-0">
            <label for="department" class="font-weight-bold">Department</label>
            <select name="department" id="department" class="form-control">
                <option value="">All</option>
                <option value="CSE" <?php if ($dept === 'CSE') echo 'selected'; ?>>CSE</option>
                <option value="ECE" <?php if ($dept === 'ECE') echo 'selected'; ?>>ECE</option>
                <option value="EEE" <?php if ($dept === 'EEE') echo 'selected'; ?>>EEE</option>
                <option value="CIVIL" <?php if ($dept === 'CIVIL') echo 'selected'; ?>>CIVIL</option>
                <option value="AI&DS" <?php if ($dept === 'AI&DS') echo 'selected'; ?>>AI&DS</option>
                <option value="MECH" <?php if ($dept === 'MECH') echo 'selected'; ?>>MECH</option>
            </select>
        </div>

        <div class="form-group col-md-3 mb-0">
            <label for="year" class="font-weight-bold">Year</label>
            <select name="year" id="year" class="form-control">
                <option value="">All</option>
                <option value="I" <?php if ($year === 'I') echo 'selected'; ?>>I</option>
                <option value="II" <?php if ($year === 'II') echo 'selected'; ?>>II</option>
                <option value="III" <?php if ($year === 'III') echo 'selected'; ?>>III</option>
                <option value="IV" <?php if ($year === 'IV') echo 'selected'; ?>>IV</option>
            </select>
        </div>

        <div class="form-group col-md-3 mb-0 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-block mt-3">Filter</button>
        </div>
    </div>
</form>

    <!-- Table -->
    <div class="mobile-scroll-table">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Reg.No</th>
                    <th>Dept</th>
                    <th>Email</th>
                    <th>Batch</th>
                    <th>Year</th>
                    <th>Address</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$sno}</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['reg_no']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['joining_year']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['current_year']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                        echo "</tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
