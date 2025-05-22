<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current file name

$query = "SELECT COUNT(*) as count 
          FROM outpass_requests 
          WHERE sid = '$sid' AND sstatus = 'Pending'";
$res = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($res);
$pending_count = $row['count'];
?>

<!-- Navbar Starts-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top topbar">
    <a class="navbar-brand font-weight" href="index.php">HMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item <?= ($current_page == 'attendance.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="attendance.php">Attendance</a>
            </li>
            <li class="nav-item <?= ($current_page == 'apply_outpass.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="apply_outpass.php">Apply Outpass</a>
            </li>

            <div class="notification-icon">
            <a class="nav-link position-relative" href="outpass_status.php">
    <i class="fa-solid fa-bell" style="top: -5px; right: -5px; font-size:21px; "></i> 
    <?php if ($pending_count > 0): ?>
        <span class="notification-dot"><?php echo $pending_count; ?></span>
    <?php endif; ?>
    </a>
</div>

            <!-- Logout Icon (Black) -->
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket" style="color: black; font-size: 22px;"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- NavBar Ends -->

<!-- CSS for Styling -->
<style>
.topbar {
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 10px 20px;
}
.navbar-brand {
    font-size: 28px;
    font-weight: bold;
    color: #333;
}
.navbar-nav .nav-item .nav-link {
    font-size: 16px;
    font-weight: 500;
    color: #555;
    transition: color 0.3s ease;
}
.navbar-nav .nav-item.active .nav-link,
.navbar-nav .nav-item:hover .nav-link {
    color: #007bff; /* Highlight active link */
}

.notification-dot {
    position: absolute;
    top: -5;
    right: 2;
    left: 0;
    width: 8px;
    height: 8px;
    background-color: rgb(202, 72, 72);
    border-radius: 50%;
    color: white;
    text-align: center;
    font-size: 12px;
    margin-left:20px;
}
.bell {
    position: relative;
}

@media (max-width: 768px) {
        .navbar-nav .nav-link {
            padding-left: 15px;
            padding-right: 15px;
        }
}
</style>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    setInterval(function() {
    fetch('check_pending_requests.php')
        .then(response => response.json())
        .then(data => {
            let notificationDot = document.querySelector('.notification-dot');
            if (data.count > 0) {
                notificationDot.textContent = data.count;
                notificationDot.style.display = 'block';
            } else {
                notificationDot.style.display = 'none';
            }
        });
}}, 5000); // Check every 5 seconds
    </script>