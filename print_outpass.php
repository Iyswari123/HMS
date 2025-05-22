<?php
include('includes/dbconn.php');

if (!isset($_GET['sid'])) {
    echo "Invalid request.";
    exit();
}

$sid = $_GET['sid'];
$query = "
    SELECT s.name, s.sid, s.department, s.current_year,
           o.reason, o.leave_date, o.return_date, o.leave_time, o.return_time,
           o.destination, o.tstatus, o.fstatus, o.astatus, o.pstatus
    FROM outpass_requests o
    INNER JOIN students s ON o.sid = s.sid
    WHERE s.sid = '$sid' AND o.pstatus = 'Approved'
";

$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "No approved outpass found.";
    exit();
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Outpass</title>
    <style>
        @media print {
            body {
                width: 70mm;
                height: 100mm;
                margin: 0;
                font-family: monospace;
                font-size: 22px;
            }
            .no-print {
                display: none;
            }
            @page {
        margin: 2mm; /* adjust margins as you like */
        size: auto;
    }
        }

        body {
            font-family: monospace;
            font-size: 14px;
            background: #fff;
            margin: 0;
            padding: 10px;
        }

        .outpass {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
            margin-bottom: 15px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .copy-label {
    text-align: center;
    font-size: 10px;
    margin-bottom: 5px;
    padding-bottom: 5px;
    border-bottom: 2px dotted grey; /* 🔥 only bottom dotted underline */
    display: inline-block;
}

        .line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }

        .label {
            font-weight: bold;
            width: 45%;
        }

        .value {
            width: 55%;
            text-align: right;
            word-break: break-word;
        }

        .signatures {
        border: 1px solid grey; /* 🧊 Outer box */
        padding: 5px;
        margin-top: 8px;
        width: flex;
    }
    .sign-line {
        margin-bottom: 3px;
    }

        button.print-btn {
            margin: 10px 0;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
        }
        .header {
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 13px;
    line-height: 1.2;
}
.header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
.header img {
            height: 56px;
        }
    
    </style>
</head>
<body>

<button onclick="window.print()" class="no-print print-btn">🖨 Print Outpass</button>
<div class="container">
   
<?php
for ($i = 0; $i < 2; $i++) {
    $copyType = ($i == 0) ? "Security Copy" : "Student Copy";
    echo "<div class='outpass'>";

    // Move header inside loop
    echo "<div class='header'>
            <img src='images/college_logo.jpg' alt='College Logo'>
            <img src='images/college_name.png' alt='College Name'>
          </div>";

    echo "<div style='text-align:center; font-weight:bold; font-size:23px; margin-top:10px; text-decoration:underline;'>
            HOSTELLER GATE PASS
          </div>";

    echo "<div class='outpass'>";
    echo "<div class='copy-label'>$copyType</div>";

    // 🔥 ADD this — current Date & Time
    date_default_timezone_set('Asia/Kolkata'); // set India timezone
    $currentDate = date('d-m-Y');
    $currentTime = date('h:i A'); // 12-hour format with AM/PM

    echo "<div class='line'><div class='label'>Date</div><div class='value'>$currentDate</div></div>";
    echo "<div class='line'><div class='label'>Time</div><div class='value'>$currentTime</div></div>";

    echo "<div class='line'><div class='label'>Name</div><div class='value'>" . htmlspecialchars($data['name']) . "</div></div>";
    echo "<div class='line'><div class='label'>Student ID</div><div class='value'>" . htmlspecialchars($data['sid']) . "</div></div>";
    echo "<div class='line'><div class='label'>Department</div><div class='value'>" . htmlspecialchars($data['department']) . "</div></div>";
    echo "<div class='line'><div class='label'>Year</div><div class='value'>" . htmlspecialchars($data['current_year']) . "</div></div>";

    echo "<div class='line'><div class='label'>Leave Date</div><div class='value'>" . htmlspecialchars($data['leave_date']) . "</div></div>";
    echo "<div class='line'><div class='label'>Leave Time</div><div class='value'>" . htmlspecialchars($data['leave_time']) . "</div></div>";
    echo "<div class='line'><div class='label'>Return Date</div><div class='value'>" . htmlspecialchars($data['return_date']) . "</div></div>";
    echo "<div class='line'><div class='label'>Return Time</div><div class='value'>" . htmlspecialchars($data['return_time']) . "</div></div>";
    echo "<div class='line'><div class='label'>Destination</div><div class='value'>" . htmlspecialchars($data['destination']) . "</div></div>";
    echo "<div class='line'><div class='label'>Reason</div><div class='value'>" . htmlspecialchars($data['reason']) . "</div></div>";

    echo "<div class='line'><div class='label'>RT Status</div><div class='value'>" . htmlspecialchars($data['tstatus']) . "</div></div>";
    echo "<div class='line'><div class='label'>Faculty</div><div class='value'>" . htmlspecialchars($data['fstatus']) . "</div></div>";
    echo "<div class='line'><div class='label'>HOD</div><div class='value'>" . htmlspecialchars($data['astatus']) . "</div></div>";
    echo "<div class='line'><div class='label'>Principal</div><div class='value'>" . htmlspecialchars($data['pstatus']) . "</div></div>";

    echo "<div class='signatures'>";
    echo "<div class='sign-line'><strong>Student Sign:</strong> _______________</div>";
    echo "<div class='sign-line'><strong>Security Sign:</strong> ______________</div>";
    echo "</div>";
    echo "</div>"; // end outpass
}
?>
</div>
</body>
</html>