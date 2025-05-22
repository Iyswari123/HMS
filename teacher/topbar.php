<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current file name


$rid = $_SESSION['rid'] ?? null;
$fid = $_SESSION['fid'] ?? null;

$isRT = $rid && str_starts_with($rid, 'R');
$isFaculty = $fid && str_starts_with($fid, 'F');
?>

<!-- Navbar Starts-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top topbar">
    <a class="navbar-brand font-weight" href="index.php">HMS</a>
    <div class="header-icons">
   <div class="bell-wrapper">
    <i class="fas fa-bell bell-icon" id="bell-icon"></i>
    <span id="notif-count-header" class="notif-badge"></span>
</div></div>
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
            <li class="nav-item <?= ($current_page == 'view_attendance.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="view_attendance.php">View Attendance</a>
            </li>

            <!-- Notification Icon -->
            <li class="nav-item">
                <a class="nav-link position-relative" href="teacher_outpass_requests.php">
                    <i class="fas fa-user-tie"></i> 
                    <span id="notif-badge" class="badge badge-danger position-absolute" style="top: -5px; color: black; right: -5px;"></span>
                </a>
            </li>

            <!-- Notification Icon -->
            <li class="nav-item">
                <a class="nav-link position-relative" href="faculty_outpass_requests.php">
                    <i class="fas fa-chalkboard-teacher"></i> 
                    <span id="notif-badge" class="badge badge-danger position-absolute" style="top: -5px; color: black; right: -5px;"></span>
                </a>
            </li>

            <!-- Logout Icon -->
            <li class="nav-item">
    <a class="nav-link font-weight-bold" href="logout.php">
        <i class="fa-solid fa-right-from-bracket" style="color: black;"></i>
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
    font-size: 25px;
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
.navbar-nav .nav-item .fa-bell, 
.navbar-nav .nav-item .fa-right-from-bracket {
    font-size: 22px;
}
.badge-danger {
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 3px 6px;
    border-radius: 50%;
}
.header-icons {
    display: flex;
    align-items: center;
    gap: 15px;
}
.bell-wrapper {
    position: relative;
    display: inline-block;
}

.notif-badge {
    position: absolute;
    top: -1px;
    right: -6px;
    background-color:rgb(202, 72, 72);
    color: #fff;
    font-size: 12px;
    padding: 2px 6px;
    min-width: 9px;
    width: 16px;
    line-height: 10px;
    height: 15px;
    line-height: 10px;
    text-align: center;
    border-radius: 6px;
    font-weight: 500;
    box-shadow: 0 0 0 2px #343a40; /* Matches sidebar bg for clean outline */
    display: none;
    transition: all 0.3s ease-in-out;
}

.bell-icon {
    color: black;
    font-size: 22px;
    cursor: pointer;
    transition: transform 0.2s;
    margin-top: 7px;
    margin-left: 7px;
}
.bell-icon:hover {
    transform: scale(1.2);
}

@media (max-width: 768px) {
.navbar-nav .nav-link {
    padding-left: 15px;
    padding-right: 15px;
}
.bell-icon {
    color: black;
    font-size: 21px;
    cursor: pointer;
    transition: transform 0.2s;
    margin-top: 7px;
    margin-left: 100px;
}
}
</style>
<script>
function fetchHeaderNotifications() {
    $.ajax({
        url: 'notifications.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const count = data.count;
            const badge = $('#notif-count-header');
            if (count > 0) {
                badge.text(count);
                badge.show();
            } else {
                badge.hide();
            }
        },
        error: function () {
            console.error('Failed to fetch notification count');
        }
    });
}

$(document).ready(function () {
    fetchHeaderNotifications();
    setInterval(fetchHeaderNotifications, 30000); // refresh every 30 secs
});
</script>

<?php if ($isRT): ?>
<script>
    $(document).ready(function () {
        function fetchRTNotifications() {
            $.ajax({
                url: 'notifications.php', // HOD notifications
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const count = data.count;
                    const badge = $('#notif-count-rt');
                    if (count > 0) {
                        badge.text(count).show();
                    } else {
                        badge.hide();
                    }
                }
            });
        }
        fetchRTNotifications();
        setInterval(fetchRTNotifications, 30000);
    });
</script>
<?php endif; ?>

<?php if ($isFaculty): ?>
<script>
    $(document).ready(function () {
        function fetchfacultyNotifications() {
            $.ajax({
                url: 'notifications.php', // Faculty notifications
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const count = data.count;
                    const badge = $('#notif-count-faculty');
                    if (count > 0) {
                        badge.text(count).show();
                    } else {
                        badge.hide();
                    }
                }
            });
        }
        fetchFacultyNotifications();
        setInterval(fetchFacultyNotifications, 30000);
    });
</script>
<?php endif; ?>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>