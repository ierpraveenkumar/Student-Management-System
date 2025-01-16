<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}



$host = "localhost";
$user = "sparx";

$password = "sparx";
$db = "schoolproject";
$data = mysqli_connect($host, $user, $password, $db);
$sql = "SELECT * FROM user WHERE usertype='student' ";
$result = mysqli_query($data, $sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        .table_th {
            padding: 20px;
            font: 20px;

        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
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
            <h1>Student Data</h1>
            <?php
            if ($_SESSION['message']) {
                echo $_SESSION['message'];
            }
            unset($_SESSION['message']);
            ?>

            <table border="1px">
                <tr>
                    <th class="table_th">Email</th>
                    <th class="table_th">UserName</th>
                    <th class="table_th">Phone</th>
                    <th class="table_th">Add Subjects</th>
                    <th class="table_th">Add Result</th>
                    <th class="table_th">View Result</th>
                    <th class="table_th">Delete</th>
                    <th class="table_th">Update</th>


                </tr>

                <?php
                while ($info = $result->fetch_assoc()) {
                    ?>

                    <tr>
                        <td class="table_td"><?php
                        echo "{$info['username']}";
                        ?></td>
                        <td class="table_td"><?php
                        echo "{$info['email']}";
                        ?></td>
                        <td class="table_td"><?php
                        echo "{$info['phone']}";
                        ?></td>
                        <td class="table_td"><?php
                        echo "<a class='btn btn-primary' href='admin_choose_subject.php?student_id={$info['id']}' >Add Subject</a>";
                        ?></td>
                        <td class="table_td"><?php
                        echo "<a class='btn btn-primary' href='admin_ad_result.php?student_id={$info['id']}' >Add Result</a>";
                        ?></td>
                        <td class="table_td"><?php
                        echo "<a class='btn btn-primary' href='admin_view_result.php?student_id={$info['id']}' >View Result</a>";
                        ?></td>

                        <td class="table_td">
                            <?php
                            echo "<a class='btn btn-danger' onClick=\"javascript:return confirm('Are You Sure You Want To Delete This');\"
    href='delete.php?student_id=" . htmlspecialchars($info['id'], ENT_QUOTES, 'UTF-8') .
                                "'>Delete</a>";
                            ?>
                        </td>

                        <td class="table_td"><?php
                        echo "<a class='btn btn-primary' href='update_student.php?student_id={$info['id']}' >Update</a>";
                        ?></td>

                    </tr>
                    <?php
                }
                ?>
            </table>

        </center>
    </div>

</body>

</html>