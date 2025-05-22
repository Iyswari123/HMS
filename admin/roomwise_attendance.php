<?php
include('../includes/dbconn.php'); // Database Connection

$query = "
    SELECT r.room_no, s.sid, s.name, 
           CASE 
               WHEN a.status = 1 THEN 'Present' 
               ELSE 'Absent' 
           END AS attendance_status
    FROM rooms r
    LEFT JOIN students s ON r.room_no = s.room_no
    LEFT JOIN attendance a ON s.sid = a.sid AND a.date = CURDATE()
    WHERE s.sid IS NOT NULL  
    ORDER BY r.room_no, s.name
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($connection));
}

$rooms = [];
while ($row = mysqli_fetch_assoc($result)) {
    $room_no = $row['room_no'];
    if (!isset($rooms[$room_no])) {
        $rooms[$room_no] = ['present' => [], 'absent' => []];
    }

    $student_entry = "<li class='list-group-item'><b>{$row['sid']}</b> - {$row['name']}</li>";

    // Swap the attendance logic
    if ($row['attendance_status'] === 'Present') {
        $rooms[$room_no]['absent'][] = $student_entry; // Show present students under 'absent'
    } else {
        $rooms[$room_no]['present'][] = $student_entry; // Show absent students under 'present'
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../includes/jquery_latest.js"></script>
    <title>HMS</title>
<style>
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #343a40;
    position: fixed;
    top: 0;
    left: 0;
    transition: transform 0.3s ease-in-out;
    z-index: 1000;
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
.main-content {
    margin-left: 250px;
    padding: 10px;
    transition: margin-left 0.3s ease;
    margin-top:-28px;
}

        .room-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 10px;
        }
        .btn-link { text-decoration: none; }
        .badge-secondary { font-size: 14px; }
        .border { border: 1px solid #ddd; }
        .present { color: green; font-weight: bold; }
        .absent { color: red; font-weight: bold; }
    /* Optional: Responsive behavior for small screens */
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
        margin-top: 20px; 
    }
}
</style>
</head>
<body>
<?php include('sidebar.php'); ?>
<br>
<br>
<div class="main-content">
    <!--  Header & Search Bar Aligned in One Line -->
    <div class="row align-items-center mb-1">
        <div class="col-md-6">
        <h3 class="mb-3">Roomwise Attendance</h3>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <input type="text" id="searchRoom" class="form-control w-50" placeholder="Enter Room Number">
            <button class="btn btn-primary ml-2" id="viewRoom">View</button>
            <button class="btn btn-secondary ml-2" id="resetView">Reset</button>
        </div>
    </div>
    <hr>
</div>
<div class="main-content">
    <div id="roomList" class="d-flex flex-column">
        <?php foreach ($rooms as $room_no => $students): ?>
            <div class="card room-card" data-room="<?= $room_no ?>">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark font-weight-bold toggle-room" data-target="#room<?= $room_no ?>">
                            Room No: <?= $room_no ?>
                        </button>
                    </h5>
                    <span class="badge badge-secondary"><?= count($students['present']) + count($students['absent']) ?> Students</span>
                </div>
                <div id="room<?= $room_no ?>" class="room-details" style="display: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success"> Present Students</h6>
                                <div class="border rounded">
                                    <?= count($students['present']) > 0 ? "<ul class='list-group'>" . implode('', $students['present']) . "</ul>" : "<p class='text-muted'>No students..</p>"; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger"> Absent Students</h6>
                                <div class="border rounded">
                                    <?= count($students['absent']) > 0 ? "<ul class='list-group'>" . implode('', $students['absent']) . "</ul>" : "<p class='text-muted'>No students..</p>"; ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
<!-- ✅ JavaScript to Handle Search, View & Reset Buttons -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    $(document).ready(function(){
        // 🔹 Ensure all room details are collapsed by default
        $(".room-details").hide();

        // 🔹 Toggle room details when clicking the room number
        $(".toggle-room").on("click", function() {
            var target = $(this).data("target");
            $(target).slideToggle(); // Smooth open/close effect
        });

        // 🔍 Live Search (Real-time Filtering)
        $("#searchRoom").on("keyup", function() {
            var value = $(this).val().trim().toLowerCase();
            $(".room-card").each(function() {
                var roomAttr = $(this).attr("data-room").trim().toLowerCase();
                $(this).toggle(roomAttr.indexOf(value) > -1);
            });
        });

        // 👁️ View Button (Shows only the searched room)
        $("#viewRoom").on("click", function() {
            var roomNo = $("#searchRoom").val().trim();

            if (roomNo === "") {
                alert("Please enter a Room Number!");
                return;
            }

            var roomCard = $(".room-card").filter(function() {
                return $(this).attr("data-room").trim() === roomNo;
            });

            if (roomCard.length === 0) {
                alert("Room not found!");
                return;
            }

            $(".room-card").hide(); // Hide all rooms
            roomCard.show(); // Show only searched room
            roomCard.find(".room-details").slideDown(); // Expand the searched room
        });

        // 🔄 Reset Button (Restores all rooms in collapsed state)
        $("#resetView").on("click", function() {
            $("#searchRoom").val("");
            $(".room-card").show(); // Show all rooms
            $(".room-details").slideUp(); // Collapse all rooms
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
