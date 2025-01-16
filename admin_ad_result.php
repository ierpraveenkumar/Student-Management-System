<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once ('database_connection.php');


if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
}
$check=mysqli_query($data,"SELECT * FROM st_choosed_subject WHERE student_id= '$student_id' ");
$check_res=$check->fetch_array();
if (empty($check_res['subjects'])) {
    $_SESSION['error_message'] = 'Subjects not found for this student. Please ask the student to choose subjects first.';
}

$fetchSubjects = mysqli_query($data, "SELECT subjects FROM st_choosed_subject where student_id = '$student_id' ");

if (isset($_POST['add_result'])) {
    $marks = array();
    foreach ($_POST['subject_marks'] as $mark) {
        $marks[] = $mark;
    }
    $marks_json = json_encode($marks);

    $query = "UPDATE st_choosed_subject SET marks='$marks_json' WHERE student_id = '$student_id' ";
    $res = mysqli_query($data, $query);
    if($res){
        $_SESSION['success_message']=" Result Added successfully";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg {
            background-color: skyblue;
            width: 400px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
    </style>

    <?php
    include 'admin_css.php';
    ?>
</head>

<body>
    <?php
    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <h1>Add Student Result</h1>
            <?php

            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }
            if(isset($_SESSION['success_message'])){
                echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);
            }
            ?>
            <div class="div_deg">
                <label>Add Marks</label>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateMarks()">
                    <?php
                    $subjectCount = 1;
                    while ($subject = $fetchSubjects->fetch_assoc()) {
                        $subject_info = json_decode($subject['subjects'], true);
                        foreach ($subject_info as $subject_name => $subject_data) {
                            echo '<div>';
                            echo '<label>' . $subject_data . '</label>';
                            echo '<input type="text" name="subject_marks[' . $subject_name . ']" placeholder="Marks">';
                            echo '</div>';
                            $subjectCount++;
                        }
                    }
                    ?>
                    <div>
                        <input class="btn btn-primary" type="submit" name="add_result" value="Add Result">
                    </div>
                </form>
            </div>
        </center>
    </div>

    <script>
        function validateMarks() {
            let inputs = document.querySelectorAll('input[type="text"]');
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value === '') {
                    alert('Please add marks for all subjects before submitting.');
                    return false;
                }
            }
            return true;
        }
    </script>
</body>

</html>