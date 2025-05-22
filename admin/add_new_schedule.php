<?php
session_start();
include('../includes/dbconn.php'); // Database connection

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$meals = ['Breakfast', 'Lunch', 'Dinner'];
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
            background-color: #f8f9fa;
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
            margin-top: 40px;
        }
    }
</style>
<?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="container mt-4">
            <h3 class="text-center"><b>Add New Meal Schedule</b></h3>
            <hr>

            <div class="text-center">
                <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add New Meal</button>
                <a href="food_schedule.php" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
<!-- Add New Meal Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Meal</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="form-group">
                        <label>Select Day</label>
                        <select id="day" name="day" class="form-control" required>
                            <option value="">-- Select Day --</option>
                            <?php foreach ($days as $day): ?>
                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Meal Type</label>
                        <select id="mealType" name="meal_type" class="form-control" required>
                            <option value="">-- Select Meal --</option>
                            <?php foreach ($meals as $meal): ?>
                                <option value="<?php echo $meal; ?>"><?php echo $meal; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Menu</label>
                        <input type="text" id="menu" name="menu" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Meal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $("#addForm").submit(function (event) {
        event.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "save_new_schedule.php",
            data: $("#addForm").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#addModal").modal("hide");
                    $("#addForm")[0].reset();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function () {
                alert("Something went wrong..");
            }
        });
    });
});
</script>

</body>
</html>
