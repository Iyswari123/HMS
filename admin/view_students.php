<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HMS - Student Status</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">
<style>
/* Your original styles retained */
.sidebar { width: 250px; background-color: #343a40; height: 100vh; position: fixed; top: 0; left: 0; transition: transform 0.3s ease-in-out; z-index: 1000; }
.main-content { margin-left: 250px; margin-top: -14px; padding: 20px; transition: margin-left 0.3s ease; }
.sidebar.closed ~ .main-content { margin-left: 60px; }
.sidebar.closed { width: 60px; }
.sidebar.closed a { font-size: 0; }
.sidebar.closed a i { font-size: 18px; }
.sidebar.closed #hms-title { display: none; }
.table td, .table th { white-space: nowrap; padding: 6px 10px; font-size: 15px; }
.mobile-scroll-table { overflow-x: hidden; width: 100%; }
.mobile-scroll-table table { width: 100%; table-layout: auto; min-width: unset; }

@media (max-width: 768px) {
  .sidebar { width: 100%; height: auto; position: relative; }
  .main-content { margin-left: 0; width: 100%; padding: 10px; margin-top: 40px; }
  .mobile-scroll-table { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  .mobile-scroll-table table { min-width: 600px; width: 100%; }
  .table td, .table th { white-space: nowrap; }
}
</style>

<?php include('sidebar.php'); ?>
<br>
<div class="main-content">
  <h3>Student Status</h3>
  <hr>

  <!-- Department + Year Filter Form -->
  <form method="GET" class="form-inline mb-3">
    <label for="department" class="mr-2">Department:</label>
    <select name="department" id="department" class="form-control mr-2">
      <option value="">All</option>
      <option value="CSE" <?= (isset($_GET['department']) && $_GET['department'] === 'CSE') ? 'selected' : '' ?>>CSE</option>
      <option value="ECE" <?= (isset($_GET['department']) && $_GET['department'] === 'ECE') ? 'selected' : '' ?>>ECE</option>
      <option value="EEE" <?= (isset($_GET['department']) && $_GET['department'] === 'EEE') ? 'selected' : '' ?>>EEE</option>
      <option value="CIVIL" <?= (isset($_GET['department']) && $_GET['department'] === 'CIVIL') ? 'selected' : '' ?>>CIVIL</option>
      <option value="MECH" <?= (isset($_GET['department']) && $_GET['department'] === 'MECH') ? 'selected' : '' ?>>MECH</option>
      <option value="AI&DS" <?= (isset($_GET['department']) && $_GET['department'] === 'AI&DS') ? 'selected' : '' ?>>AI&DS</option>
      <option value="MBA" <?= (isset($_GET['department']) && $_GET['department'] === 'MBA') ? 'selected' : '' ?>>MBA</option>
      <!-- Add more if needed -->
    </select>

    <label for="year" class="mr-2">Year:</label>
    <select name="year" id="current_year" class="form-control mr-2">
      <option value="">All</option>
      <option value="I" <?= (isset($_GET['current_year']) && $_GET['current_year'] === 'I') ? 'selected' : '' ?>>I</option>
      <option value="II" <?= (isset($_GET['current_year']) && $_GET['current_year'] === 'II') ? 'selected' : '' ?>>II</option>
      <option value="III" <?= (isset($_GET['current_year']) && $_GET['current_year'] === 'III') ? 'selected' : '' ?>>III</option>
      <option value="IV" <?= (isset($_GET['current_year']) && $_GET['current_year'] === 'IV') ? 'selected' : '' ?>>IV</option>
    </select>

    <button type="submit" class="btn btn-primary btn-sm mr-2">Filter</button>
    <a href="view_students.php" class="btn btn-secondary btn-sm">Reset</a>
  </form>

  <div class="mobile-scroll-table">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>SID</th>
          <th>Name</th>
          <th>Reg_no</th>
          <th style="width: 200px;">Email ID</th>
          <th>Dept</th>
          <th>Batch</th>
          <th>Year</th>
          <th>Address</th>
          <th>Contact No</th>
          <th>Parent No</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $filters = [];
        $params = [];

        if (!empty($_GET['department'])) {
            $filters[] = "department = ?";
            $params[] = $_GET['department'];
        }

        if (!empty($_GET['year'])) {
            $filters[] = "current_year = ?";
            $params[] = $_GET['year'];
        }

        $sql = "SELECT * FROM students";
        if (count($filters) > 0) {
            $sql .= " WHERE " . implode(" AND ", $filters);
        }
        $sql .= " ORDER BY sid ASC";

        if (count($params) > 0) {
            $stmt = $connection->prepare($sql);
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $query_run = $stmt->get_result();
        } else {
            $query_run = mysqli_query($connection, $sql);
        }

        if (!$query_run) {
            die("Query failed: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<tr>
                        <td>{$row['sid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['st_id']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['joining_year']}</td>
                        <td>{$row['current_year']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['phone']}</td>
                        <td class='d-flex gap-1'>
                            <a href='edit_student.php?id={$row['sid']}' class='btn btn-info btn-sm'>E</a>
                            <a href='delete_student.php?id={$row['sid']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>D</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>No students found.</td></tr>";
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
</body>
</html>
