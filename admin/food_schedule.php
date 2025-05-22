<?php
session_start();
include('../includes/dbconn.php'); // Database connection

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch food schedule
$sql = "SELECT * FROM food_schedule ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), FIELD(meal_type, 'Breakfast', 'Lunch', 'Dinner')";
$result = $connection->query($sql);

$schedule = [];
while ($row = $result->fetch_assoc()) {
    $schedule[$row['day']][$row['meal_type']] = $row['menu'];
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
            margin-top: -38px;
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

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-edit {
            padding: 5px 10px;
            font-size: 14px;
        }

        .btn-add {
            margin: 20px 0;
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
                padding: 20px;
                margin-top: 20px;
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
<br>
<div class="wrapper">
    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>
    <br>
    <div class="main-content">
        <div class="">
            <h3 class="mb-3">Weekly Meal Schedule</h3>
            <hr>
            <div class="mobile-scroll-table">
            <table class="table table-bordered text-center" style="border-collapse: separate; border-spacing: 0 10px;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Day</th>
                            <th>Breakfast <small>(8:00 AM)</small></th>
                            <th>Lunch <small>(12:35 PM)</small></th>
                            <th>Dinner <small>(7:30 PM)</small></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($days as $day): ?>
                            <tr>
                                <td><strong><?php echo $day; ?></strong></td>
                                <?php foreach (['Breakfast', 'Lunch', 'Dinner'] as $meal): ?>
                                    <td>
                                        <?php 
                                        if (isset($schedule[$day][$meal])) {
                                            echo htmlspecialchars($schedule[$day][$meal]);
                                        } else {
                                            echo "<span class='text-muted'>Not Scheduled</span>";
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td>
                                    <a href="edit_food_schedule.php?day=<?php echo urlencode($day); ?>" class="btn btn-sm btn-primary btn-edit" title="Edit schedule for <?php echo htmlspecialchars($day); ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($schedule)): ?>
                            <tr>
                                <td colspan="5" class="text-muted">No schedule entries available. Please add a new meal schedule.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="text-center">
                    <a href="add_new_schedule.php" class="btn btn-success btn-add">
                        <i class="fas fa-plus-circle"></i> Add Schedule Entry
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
