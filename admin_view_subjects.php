<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}
require_once ('database_connection.php');

// Query to fetch streams
$subjectsql = "SELECT s.* , c.*, st.* FROM subjects as s
INNER JOIN class as c ON s.class_id=c.id
INNER JOIN stream as st ON s.stream_id=st.id";
$subjectt = mysqli_query($data, $subjectsql);
$dta = [];
while ($subject = $subjectt->fetch_assoc()) {
    $dta[] = $subject;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All class</title>
    <?php include 'admin_css.php'; ?>
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
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h2>View all Subjects , related classes and streams</h2>
            <span style="background-color: blueviolet; font-size: 30px; color:crimson ; padding:5px;" ><a href="admin_add_subjects.php">Add Subjects</a></span>
            <?php if (isset($_SESSION['sub_save_success'])) {
                echo '<p style="color:green">' . $_SESSION['sub_save_success'] . '</p>';
                unset($_SESSION['sub_save_success']);
            } ?>
            <table border="1px">
                <tr>
                    <th class="table_th">Serial no</th>
                    <th class="table_th">Stream Name</th>
                    <th class="table_th">Class Name</th>
                    <th class="table_th">Subjects</th>
                </tr>
                <?php
                $serial = 1; // Initialize serial number
                foreach ($dta as $subject) {
                    $subjects = json_decode($subject['subject_info'], true);
                    ?>
                    <tr>
                        <td class="table_td"><?php echo $serial; ?></td>
                        <td class="table_td"><?php echo $subject['stream_name']; ?></td>
                        <td class="table_td"><?php echo $subject['class_name']; ?></td>
                        <td class="table_td">
                            <?php
                            $subjectList = '';
                            $counter = 1;
                            foreach ($subjects as $subjectName => $subjectType) {
                                $subjectList .= "$counter.  $subjectName => $subjectType<br>";
                                $counter++;
                            }
                            echo $subjectList;
                            ?>
                        </td>
                    </tr>
                    <?php
                    $serial++; // Increment serial number
                }

                ?>
            </table>
        </center>
    </div>
</body>

</html>