<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

// Handle update submission
if (isset($_POST['student_id']) && isset($_POST['room_no'])) {
    $student_id = $_POST['student_id'];
    $room_no = $_POST['room_no'];

    // Get current occupancy
    $count_query = "SELECT COUNT(*) AS occupied FROM students WHERE room_no = '$room_no'";
    $count_result = mysqli_query($connection, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $occupied = $count_row['occupied'];

    // Get room capacity
    $capacity_query = "SELECT capacity FROM rooms WHERE room_no = '$room_no'";
    $capacity_result = mysqli_query($connection, $capacity_query);
    $capacity_row = mysqli_fetch_assoc($capacity_result);
    $capacity = $capacity_row['capacity'];

    if ($occupied >= $capacity) {
        $message = "Cannot assign student. Room $room_no is already full.";
    } else {
        $update_query = "UPDATE students SET room_no = '$room_no' WHERE sid = '$student_id'";
        $result = mysqli_query($connection, $update_query);
        $message = $result ? "Room updated successfully!" : "Room update failed: " . mysqli_error($connection);
    }
}


// Fetch students with rooms
$students_query = "SELECT s.sid, s.name, s.gender, s.room_no, r.capacity,
                  (SELECT COUNT(*) FROM students WHERE room_no = s.room_no) AS student_count 
                   FROM students s 
                   LEFT JOIN rooms r ON s.room_no = r.room_no 
                   WHERE s.room_no IS NOT NULL";
$students_result = mysqli_query($connection, $students_query);

// Fetch rooms
$rooms_query = "SELECT room_no FROM rooms";
$rooms_result = mysqli_query($connection, $rooms_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<title>HMS</title>
<style>
    body {
        background-color: #f8f9fa;
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
        margin-left: 250px;
        margin-top: 10px;
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
    .btn-update {
        background-color: #007bff;
        color: white;
        font-weight: 500;
        border-radius: 6px;
        box-shadow: 0 3px 6px rgba(0, 123, 255, 0.3);
        transition: 0.3s ease;
        margin-left:200px;
    }

    .btn-update:hover {
        background-color: #0069d9;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.5);
    }

    .btn-back {
        border: 1px solid #6c757d;
        color: #343a40;
        font-weight: 500;
        border-radius: 6px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(108, 117, 125, 0.2);
        transition: 0.3s ease;
    }

    .btn-back:hover {
        background-color: #f8f9fa;
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: #000;
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
            margin-top: 60px;
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
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="main-content">

<h3 class="mb-1">Update Rooms</h3>
<br>
<?php
if (!empty($message)) {
    $isError = strpos($message, 'Cannot assign') !== false; // Check if it's an error
    $alertClass = $isError ? 'alert-danger' : 'alert-info';
    echo "<div class='alert $alertClass text-center'>$message</div>";
}
?>

<form method="POST" class="form-group row justify-content-center">
<div class="col-md-4">
    <label>Search Student Name:</label>
    <input type="text" id="studentSearch" class="form-control" placeholder="Type student name..." onkeyup="filterStudentList()">
    
    <input type="hidden" name="student_id" id="selectedStudentId" required>

    <ul id="studentResults" class="list-group mt-2" style="max-height: 200px; overflow-y: auto; display: none;"></ul>
</div>
    <div class="col-md-4">
        <label>Select Room:</label>
        <select name="room_no" class="form-control" required>
            <option value="">-- Select Room --</option>
            <?php
            mysqli_data_seek($rooms_result, 0);
            while ($room = mysqli_fetch_assoc($rooms_result)): ?>
                <option value="<?php echo $room['room_no']; ?>"><?php echo $room['room_no']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div id="room_alert" class="alert alert-danger" style="display: none;"></div>

    <div class="col-md-4 d-flex align-items-end justify-content-between">
    <button type="submit" class="btn btn-update">
        <i class="fas fa-save mr-1"></i> Update
    </button>

    <a href="assign_room.php" class="btn btn-back">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>
</div>
</form>

<hr>
<div class="d-flex justify-content-between align-items-center">
<h3 class="mb-0">Students & Assigned Rooms</h3>
    <div class="col-md-4">
        <label for="genderFilter">Filter by Gender:</label>
        <select id="genderFilter" class="form-control" onchange="filterGender()">
            <option value="All">All</option>
            <option value="Male">Boys</option>
            <option value="Female">Girls</option>
        </select>
    </div>
</div>
<br>
<div class="mobile-scroll-table">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Student Name</th>
                <th>Assigned Room</th>
                <th>Capacity</th>
                <th>Occupied</th>
            </tr>
        </thead>
        <tbody id="student-table-body">
            <?php
            mysqli_data_seek($students_result, 0);
            while ($student = mysqli_fetch_assoc($students_result)): ?>
                <tr data-gender="<?php echo $student['gender']; ?>">
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['room_no']; ?></td>
                    <td><?php echo $student['capacity']; ?></td>
                    <td><?php echo $student['student_count']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function filterGender() {
    const gender = document.getElementById('genderFilter').value;
    const rows = document.querySelectorAll('#student-table-body tr');

    rows.forEach(row => {
        const rowGender = row.getAttribute('data-gender');
        row.style.display = (gender === 'All' || rowGender === gender) ? '' : 'none';
    });
}

window.onload = function () {
    filterGender(); // Show all by default
};
const studentList = [
        <?php
        mysqli_data_seek($students_result, 0);
        while ($s = mysqli_fetch_assoc($students_result)) {
            $id = $s['sid'];
            $name = addslashes($s['name']);
            echo "{ id: '$id', name: '$name' },";
        }
        ?>
    ];

    function filterStudentList() {
        const search = document.getElementById('studentSearch').value.toLowerCase().trim();
        const results = document.getElementById('studentResults');
        const hiddenInput = document.getElementById('selectedStudentId');

        results.innerHTML = '';
        hiddenInput.value = '';

        if (search.length === 0) {
            results.style.display = 'none';
            return;
        }

        const filtered = studentList.filter(s => s.name.toLowerCase().includes(search));

        if (filtered.length === 0) {
            results.style.display = 'none';
            return;
        }

        filtered.forEach(student => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action';
            li.textContent = student.name;
            li.onclick = function () {
                document.getElementById('studentSearch').value = student.name;
                hiddenInput.value = student.id;
                results.style.display = 'none';
            };
            results.appendChild(li);
        });

        results.style.display = 'block';
    }
</script>

</body>
</html>
