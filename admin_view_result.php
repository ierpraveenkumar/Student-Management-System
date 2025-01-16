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

$student_id = $_GET['student_id'];

$sql = "SELECT st.*, u.*,s.* ,c.*
        FROM st_choosed_subject st
        INNER JOIN user u ON st.student_id = u.id
        INNER JOIN stream s ON st.stream_id = s.id
        INNER JOIN class c ON st.class_id = c.id
        WHERE st.student_id=$student_id";
$resultt = mysqli_query($data, $sql);
$result = $resultt->fetch_assoc();

if($result['marks']==null){
    $_SESSION['error_message']="Marks Not Availavle plz add marks first";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students Result</title>
    <?php
    include 'admin_css.php';
    ?>
    <style type="text/css">
        .table_th {
            padding: 20px;
            font-size: 20px;
        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
        }
    </style>
</head>

<body>
    <?php
    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <h2>View Result Annual Examination  : <?php echo date('m-y');?></h2>
            
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }
            ?>
            <table border="1px">
                <thead>
                    <tr>
                        <th class="table_th">Student Name</th>
                        <th class="table_th">class Name</th>
                        <th class="table_th">stream Name</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="table_td"><?php echo $result['name']; ?></td>
                        <td class="table_td"><?php echo $result['class_name']; ?></td>
                        <td class="table_td"><?php echo $result['stream_name']; ?></td>
                    </tr>
                </tbody>
            </table>





            <table border="1px">

                <thead>
                    <?php
                    $subjects = json_decode($result['subjects'], true);
                    foreach ($subjects as $subject) {
                        echo "<th class='table_th'>$subject</th>";
                    }
                    echo "<th class='table_th'>Percentage</th>";
                    echo "<th class='table_th'>Result Status</th>";
                    ?>
                </thead>

                <tbody>
                    <?php
                    // Reset the result pointer to the beginning
                    // $result->data_seek(0);
                    $marks = json_decode($result['marks'], true);

                    // while ($info = $result->fetch_assoc()) {
                    // $marks = json_decode($info['marks'], true);
                    $totalMarks = array_sum($marks);
                    $percentage = ($totalMarks / (count($marks) * 100)) * 100;
                    $resultStatus = '';

                    if ($percentage >= 60) {
                        $resultStatus = 'First';
                    } elseif ($percentage >= 50) {
                        $resultStatus = 'Second';
                    } elseif ($percentage >= 40) {
                        $resultStatus = 'Pass';
                    } else {
                        $resultStatus = 'Fail';
                    }
                    ?>
                    <tr>

                        <?php
                        foreach ($marks as $mark) {
                            echo "<td class='table_td'>$mark</td>";
                        }
                        echo "<td class='table_td'>".round($percentage,2)."%</td>";
                        echo "<td class='table_td'>$resultStatus</td>";
                        ?>
                    </tr>
                </tbody>
            </table>


        </center>
    </div>

</body>

</html>