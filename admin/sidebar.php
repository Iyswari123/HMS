<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current file name

$aid = $_SESSION['aid'] ?? null;
$pid = $_SESSION['pid'] ?? null;

$isHOD = $aid && str_starts_with($aid, 'A');
$isPrincipal = $pid && str_starts_with($pid, 'P');
?>
<div class="sidebar">
<div class="sidebar-header">    
<h4 class="text-center text-white" id="hms-title">HMS</h4>
        <div class="header-icons">
   <div class="bell-wrapper">
    <i class="fas fa-bell bell-icon" id="bell-icon"></i>
    <span id="notif-count-header" class="notif-badge"></span>
</div>
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
       </div></div>
    <br>

    <a href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <!-- Attendance Dropdown -->
    <a href="#" class="dropdown-toggle" data-menu="attendance-menu">
        <i class="fas fa-clipboard-list"></i> Attendance Record <i class="fas fa- dropdown-icon"></i>
    </a>
    <div id="attendance-menu" class="dropdown-container">
        <a href="view_attendance.php">
            <i class="fas fa-calendar-day"></i>Today's Report
        </a>
        <a href="roomwise_attendance.php">
            <i class="fas fa-users"></i>Roomwise Report
        </a>
        <a href="overall_attendance.php">
            <i class="fas fa-tachometer-alt"></i>Overall Report
        </a>
    </div>

    <!-- Student Dropdown -->
    <a href="#" class="dropdown-toggle" data-menu="student-menu">
        <i class="fas fa-user-graduate"></i> Student <i class="fas fa- dropdown-icon"></i>
    </a>
    <div id="student-menu" class="dropdown-container">
        <a href="add_student.php">
            <i class="fas fa-user-plus"></i> New Student
        </a>
        <a href="view_students.php">
            <i class="fas fa-users"></i> Student Status
        </a>
    </div>

    <!-- Faculty Dropdown -->
    <a href="#" class="dropdown-toggle" data-menu="faculty-menu">
        <i class="fas fa-chalkboard-teacher"></i> Faculty <i class="fas fa- dropdown-icon"></i>
    </a>
    <div id="faculty-menu" class="dropdown-container">
        <a href="add_teacher.php">
            <i class="fas fa-user-tie"></i> New Faculty
        </a>
        <a href="view_teachers.php">
            <i class="fas fa-user-check"></i> Faculty Status
        </a>
    </div>

     <!-- Meal Dropdown -->
     <a href="#" class="dropdown-toggle" data-menu="meal-menu">
        <i class="fas fa-door-open"></i>Manage Room <i class="fas fa- dropdown-icon"></i>
    </a>
    <div id="meal-menu" class="dropdown-container">
        <a href="room_allocation.php">
            <i class="fas fa-user-plus"></i>Manage Room
        </a>
        <a href="assign_room.php">
            <i class="fas fa-users"></i>Assigning Room
        </a>
    </div>

    <a href="food_schedule.php">
        <i class="fas fa-utensils"></i> Meal Schedule
    </a>

    <a class="nav-link" href="admin_outpass_requests.php">
        <i class="fas fa-external-link-alt"></i> HOD Approval
        <span id="notif-count" class="badge badge-danger ml-2" style="display:none;"></span>
    </a>

<a class="nav-link" href="principal_outpass_requests.php">
    <i class="fas fa-user-tie"></i> Principal Approval
    <span id="notif-count" class="badge badge-danger ml-2" style="display:none;"></span>
</a>

    <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- Sidebar Styles -->
<style>
/* Sidebar Styles */
.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    padding-top: 25px;
    transition: width 0.3s ease-in-out;
    z-index: 999;
}
.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 12px;
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
    top: -6px;
    right: -6px;
    background-color:rgb(202, 72, 72);
    color: #fff;
    font-size: 11px;
    padding: 2px 6px;
    min-width: 13px;
    height: 15px;
    line-height: 10px;
    text-align: center;
    border-radius: 6px;
    font-weight: 600;
    box-shadow: 0 0 0 2px #343a40; /* Matches sidebar bg for clean outline */
    display: none;
    transition: all 0.3s ease-in-out;
}

.bell-icon {
    color: white;
    font-size: 20px;
    cursor: pointer;
    transition: transform 0.2s;
}
.bell-icon:hover {
    transform: scale(1.2);
}

.toggle-btn {
    background: none;
    border: none;
    font-size: 23px;
    color: white;
    cursor: pointer;
    transition: transform 0.3s;
}

.toggle-btn:hover {
    transform: scale(1.2);
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 20px;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    font-size: 16px;
    transition: all 0.3s;
    margin-bottom: 20px; 
}

.sidebar a i {
    width: 20px;
}

.sidebar a:hover {
    background-color: #575757;
    padding-left: 20px;
}

/* Dropdown Styling */
.dropdown-container {
    max-height: 0;
    overflow: hidden;
    padding-left: 20px;
    background-color: #464a4e;
    transition: max-height 0.3s ease-in-out, padding 0.3s ease-in-out;
}

.dropdown-container.open {
    max-height: 150px;
    padding-top: 0px;
    padding-bottom: 0px;
}

.dropdown-container a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ddd;
    padding: 10px 15px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
    margin-bottom: 12px; 
}

.dropdown-container a:hover {
    background-color: #575757;
}

.dropdown-icon {
    margin-left: auto;
    transition: transform 0.3s ease-in-out;
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

.sidebar.closed #bell-icon {
    display: none;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .sidebar {
        width: 0; /* Sidebar hidden by default on mobile */
        position: fixed;
        margin-bottom: 150px;
    }
    .sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 15px;
}
    .sidebar.open {
        width: 250px; /* Sidebar shown when open on mobile */
        margin-bottom: 150px;
    }

    .sidebar a {
        font-size: 0;
    }

    .sidebar a i {
        font-size: 0px;
    }

    .sidebar .toggle-btn {
        text-align: center;
        width: 100%;
    }
    .main-content {
        margin-left: 0;
        padding: 15px;
    }
}
@media (max-width: 768px) {
    #hms-title {
    display: none !important;
  }
    .sidebar.close #hms-title {
        display: none !important;
    }
    .top-header {
        padding-top: 10px;
        justify-content: flex-start;
        height: 45px;
        font-color: black;
    }

    .toggle-btn {
        font-size: 25px;
    }
    #hms-title,
    .toggle-btn {
        color: black !important;
    }
    .bell-icon {
        color: black !important;
    }
    
}
</style>

<!-- Sidebar Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownLinks = document.querySelectorAll(".dropdown-toggle");

        dropdownLinks.forEach((link) => {
            link.addEventListener("click", function (event) {
                event.preventDefault();
                let menuId = this.getAttribute("data-menu");
                let menu = document.getElementById(menuId);
                let icon = this.querySelector(".dropdown-icon");

                if (menu.classList.contains("open")) {
                    menu.classList.remove("open");
                    icon.style.transform = "rotate(0deg)";
                } else {
                    document.querySelectorAll(".dropdown-container").forEach((m) => {
                        if (m.id !== menuId) {
                            m.classList.remove("open");
                        }
                    });

                    document.querySelectorAll(".dropdown-icon").forEach((i) => {
                        if (i !== icon) {
                            i.style.transform = "rotate(0deg)";
                        }
                    });

                    menu.classList.add("open");
                    icon.style.transform = "rotate(180deg)";
                }
            });
        });
    });

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
<?php if ($isHOD): ?>
<script>
    $(document).ready(function () {
        function fetchHODNotifications() {
            $.ajax({
                url: 'notifications.php', // HOD notifications
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const count = data.count;
                    const badge = $('#notif-count-hod');
                    if (count > 0) {
                        badge.text(count).show();
                    } else {
                        badge.hide();
                    }
                }
            });
        }
        fetchHODNotifications();
        setInterval(fetchHODNotifications, 30000);
    });
</script>
<?php endif; ?>

<?php if ($isPrincipal): ?>
<script>
    $(document).ready(function () {
        function fetchPrincipalNotifications() {
            $.ajax({
                url: 'principal_notifications.php', // Principal notifications
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const count = data.count;
                    const badge = $('#notif-count-principal');
                    if (count > 0) {
                        badge.text(count).show();
                    } else {
                        badge.hide();
                    }
                }
            });
        }
        fetchPrincipalNotifications();
        setInterval(fetchPrincipalNotifications, 30000);
    });
</script>
<?php endif; ?>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>