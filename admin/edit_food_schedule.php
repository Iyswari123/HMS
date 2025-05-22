<?php
session_start();
include('../includes/dbconn.php'); // Database connection

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

if (!isset($_GET['day'])) {
    header('Location: food_schedule.php');
    exit();
}

$day = $_GET['day'];
$meals = ['Breakfast', 'Lunch', 'Dinner'];

// Fetch existing meal data
$schedule = [];
$sql = "SELECT meal_type, menu FROM food_schedule WHERE day = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $day);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $schedule[$row['meal_type']] = $row['menu'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">   
<style>
body {
font-family: Arial, sans-serif;
}
/* Base Layout */
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
    padding: 20px;
    transition: margin-left 0.3s ease;
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
.card {
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}
.modal-content {
    border-radius: 10px;
}
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
        margin-top: 20px;  /* Add spacing */
    }
}
</style>
</head>
<?php include('sidebar.php'); ?>
    <div class="main-content">
        <div class="container mt-4">
            <h3 class="text-center"><b>Update Schedule - <?php echo htmlspecialchars($day); ?></b></h3>
            <hr>
<br>
            <div class="row">
                <?php foreach ($meals as $meal): ?>
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <h5><?php echo $meal; ?></h5>
                            <p id="menu-<?php echo $meal; ?>">
                                <?php echo isset($schedule[$meal]) ? htmlspecialchars($schedule[$meal]) : '<span class="text-muted">Not Set</span>'; ?>
                            </p>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="openModal('<?php echo $meal; ?>', '<?php echo isset($schedule[$meal]) ? addslashes($schedule[$meal]) : ''; ?>')">
                                Edit
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
<br>
            <div class="text-center mt-4">
                <a href="food_schedule.php" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Edit Meal</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="mealType" name="meal_type">
                    <input type="hidden" id="day" name="day" value="<?php echo htmlspecialchars($day); ?>">
                    <div class="form-group">
                        <label>Menu</label>
                        <input type="text" id="menuInput" name="menu" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script>
function openModal(meal, currentMenu) {
    document.getElementById('modalTitle').innerText = "Edit " + meal;
    document.getElementById('mealType').value = meal;
    document.getElementById('menuInput').value = currentMenu;
}

// AJAX form submission
$(document).ready(function () {
    $("#editForm").submit(function (event) {
        event.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "update_food_schedule.php",
            data: $("#editForm").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#menu-" + response.meal).text(response.newMenu);
                    $("#editModal").modal("hide");
                } else {
                    alert("Error updating meal");
                }
            },
            error: function () {
                alert("Something went wrong. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
