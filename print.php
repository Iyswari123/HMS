<?php
$name = escapeshellarg($_GET['name']);
$roll = escapeshellarg($_GET['roll']);
$from = escapeshellarg($_GET['from']);
$to = escapeshellarg($_GET['to']);
$reason = escapeshellarg($_GET['reason']);

// This line calls the Python script with those values
$output = shell_exec("python3 print_outpass.py $name $roll $from $to $reason");

// Show the result
echo "<pre>$output</pre>";
?>
