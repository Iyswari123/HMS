<?php
session_start();
include('../includes/dbconn.php'); // Include database connection

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>HMS</title>
</head>
<body style="background-color: #f8f9fa;">
<style>
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
.table td, .table th {
    white-space: nowrap;
}
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 10px;
        margin-top: 40px;
    }
    .mobile-scroll-table {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .mobile-scroll-table table {
        min-width: 600px;
        width: 100%;
    }
}
</style>

<?php include('sidebar.php'); ?>
<br>
<div class="main-content">
    <h3>Faculty Status</h3>
    <hr>

    <!-- Gender Filter -->
    <form method="GET" class="form-inline mb-3">
        <label for="gender" class="mr-2">Filter by:</label>
        <select name="gender" id="gender" class="form-control mr-2">
            <option value="">All</option>
            <option value="Male" <?= (isset($_GET['gender']) && $_GET['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($_GET['gender']) && $_GET['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm mr-2">Filter</button>
        <a href="view_teachers.php" class="btn btn-secondary btn-sm">Reset</a>
    </form>

    <!-- Success Message -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="mobile-scroll-table">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>RID</th>
                    <th>RT Name</th>
                    <th>Email ID</th>
                    <th>Contact No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $gender_filter = isset($_GET['gender']) && !empty($_GET['gender']) ? $_GET['gender'] : '';

                if ($gender_filter) {
                    $stmt = $connection->prepare("SELECT * FROM teachers WHERE gender = ? ORDER BY rid ASC");
                    $stmt->bind_param("s", $gender_filter);
                    $stmt->execute();
                    $query_run = $stmt->get_result();
                } else {
                    $query_run = mysqli_query($connection, "SELECT * FROM teachers ORDER BY rid ASC");
                }

                if (!$query_run) {
                    die("Database query failed: " . mysqli_error($connection));
                }

                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['rid']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['mobile']) . "</td>
                                <td>
                                    <a href='edit_teacher.php?id={$row['rid']}' class='btn btn-info btn-sm'>E</a>
                                    <a href='delete_teacher.php?id={$row['rid']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this faculty?\")'>D</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No faculty found.</td></tr>";
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
    let mainContent = document.querySelectorAll('.main-content');

    sidebar.classList.toggle('closed');

    if (sidebar.classList.contains('closed')) {
        hmsTitle.style.display = 'none';
        mainContent.forEach(el => el.classList.add('expanded'));
    } else {
        hmsTitle.style.display = 'block';
        mainContent.forEach(el => el.classList.remove('expanded'));
    }
}
</script>
</body>
</html>
