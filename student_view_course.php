<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'admin') {
    header('location: login.php');
}
require_once('database_connection.php');

$id = $_SESSION['userid'];
$username = $_SESSION['names'];

$sql = "SELECT s.*, u.name, c.class_name, st.stream_name
        FROM st_choosed_subject s
        INNER JOIN user u ON s.student_id = u.id
        INNER JOIN class c ON s.class_id = c.id
        INNER JOIN stream st ON s.stream_id = st.id
        WHERE s.student_id= $id";
$result = mysqli_query($data, $sql);

$info = $result->fetch_assoc();
if (is_null($info['subjects'])) {
    $message = "Please Choose Courses First And then check again.....To Add Subjects contact ur teacher first";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <?php include 'student_css.php'; ?>
    <style type="text/css">
        .card-container {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            width: 45%;
            margin: 10px;
        }

        .card-left {
            background-color: #f9f9f9;
        }

        .card-right {
            background-color: #f0f0f0;
        }

        .card h3 {
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .card h4 {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <?php include 'student_sidebar.php'; ?>
    <div class="content">
        <?php if (isset($message)) {
            echo "<h4 style='color:red ;' >$message</h4>";
        } ?>

        <center>

        <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['exist_message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['exist_message'] . "</div>";
                unset($_SESSION['exist_message']);
            }
            if (isset($_SESSION['none_select_message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['none_select_message'] . "</div>";
                unset($_SESSION['none_select_message']);
            }
            ?>

            <h2>Hello <?php echo $username; ?></h2>
            <div class="card-container">
                <div class="card card-left">
                    <h3>Class: <?php echo $info['class_name']; ?></h3>
                    <h4>Stream: <?php echo $info['stream_name']; ?></h4>
                    <h4>Student Name: <?php echo $info['name']; ?></h4>
                </div>
                <div class="card card-right">
                    <h3>Your Subjects:</h3>
                    <?php
                    $subjects = json_decode($info['subjects'], true);
                    foreach ($subjects as $subject) {
                        echo "<h4>$subject</h4>";
                    }
                    ?>
                </div>
            </div>
        </center>
    </div>
</body>

</html>

