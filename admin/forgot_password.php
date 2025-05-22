<?php
session_start();
include('../includes/dbconn.php');
$msg = "";

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_pass = mysqli_real_escape_string($connection, $_POST['new_password']);
    $confirm_pass = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    if ($new_pass !== $confirm_pass) {
        $msg = "❌ Password do not match!";
    } else {
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        $check = mysqli_query($connection, "SELECT * FROM admin WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $update = mysqli_query($connection, "UPDATE admin SET password='$hashed_password' WHERE email='$email'");
            $msg = $update ? "✅ Password reset successfully!" : "❌ Error updating password!";
        } else {
            $msg = "❌ No account found with that email!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: url('../images/1.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .reset-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        h3 {
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        button[name="reset"] {
            background-color: rgb(0, 123, 255);
            color: white;
            border: 2px solid #4a4a4a;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button[name="reset"]:hover {
            background-color: #5a5a6e;
            border-color: #343a40;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <br>
            <center><h3>HOSTEL MANAGEMENT SYSTEM</h3></center>
            <br><br>
            <div class="card reset-container">
                <div class="card-header text-center">
                    <strong>Reset Admin Password</strong>
                </div>
                <div class="card-body">
                    <?php if (!empty($msg)): ?>
                        <div class="alert alert-info text-center"><?php echo $msg; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="email">Email ID</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="New password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                        </div>
                        <br>
                        <center>
                            <button type="submit" name="reset">Reset Password</button>
                        </center>
                        <div class="text-center mt-3">
                            <a href="../index.php">← Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
