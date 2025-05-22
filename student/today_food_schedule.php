<?php
session_start();
include('../includes/dbconn.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index2.php');
    exit();
}

$today = date('l');
$meals = ['Breakfast', 'Lunch', 'Dinner'];

$sql = "SELECT meal_type, menu FROM food_schedule WHERE day = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$schedule = [];
while ($row = $result->fetch_assoc()) {
    $schedule[$row['meal_type']] = $row['menu'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="../includes/jquery_latest.js"></script>
    <title>HMS</title>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100%;
            margin: 0;
            overflow: hidden; /* Prevent all scrolling */
            overflow: auto;
            scrollbar-width: none; /* Firefox */
        }

        body::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        .card-container {
            height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Move to top */
            margin-top: 100px; /* Adjust this value as needed */
        }
        .navbar-brand {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .food-card {
            max-width: 600px;
            width: 100%;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: #212529;
            color: white;
            padding: 1.25rem 1.5rem;
        }

        .card-header h4 {
            margin-bottom: 0;
            font-weight: 600;
        }

        .meal-label {
            font-weight: 600;
            color: #343a40;
        }

        .meal-value {
            color: #6c757d;
            text-align: right;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border: none;
            border-bottom: 1px solid #e9ecef;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .btn-back {
            margin-top: 1.5rem;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background-color: #e9ecef;
            border-color:rgb(148, 152, 155);
            color:black;
        }
    @media (max-width: 576px) {
    .food-card {
        margin: 20px;
        width: 100%;
        max-width: 100%;
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .card-container {
        padding: 10px;
        align-items: flex-start; /* prevent full vertical centering */
        margin-top:100px;
    }

    .card-header h4 {
        font-size: 1.2rem;
    }

    .btn-back {
        padding: 8px 20px;
        font-size: 0.9rem;
        color:black;
    }

    .list-group-item {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
}
</style>
</head>
<body>
<nav class="topbar navbar bg-white px-3">
    <span class="navbar-brand mb-0 h5 text-dark">HMS</span>
</nav>


<div class="card-container">
    <div class="food-card bg-white">
        <div class="card-header text-center">
            <h4>Today's Meal Schedule - <?php echo $today; ?></h4>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <?php foreach ($meals as $meal): ?>
                    <li class="list-group-item">
                        <span class="meal-label"><?php echo $meal; ?></span>
                        <span class="meal-value">
                            <?php 
                                echo isset($schedule[$meal]) 
                                    ? htmlspecialchars($schedule[$meal]) 
                                    : "<span class='text-muted'>Not Set</span>";
                            ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="text-center pb-4">
            <a href="dashboard.php" class="btn btn-outline-secondary btn-back">← Back</a>
        </div>
    </div>
</div>
</body>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('open');
        document.querySelector('.main-content').classList.toggle('shifted');
    }
</script>

</html>

