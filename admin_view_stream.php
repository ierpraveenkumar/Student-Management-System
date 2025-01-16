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
require_once('database_connection.php');

// Query to fetch streams
$strmsql = "SELECT * FROM `stream`";
$stream = mysqli_query($data, $strmsql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Groups</title>
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
            <h2>View All Stream</h2>
            <table border="1px">
                <tr>
                    <th class="table_th">Serial no</th>
                    <th class="table_th">Stream Name</th>
                </tr>
                <?php
                $serial = 1;
                while ($streamm = $stream->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="table_td"><?php echo $serial; ?></td>
                        <td class="table_td"><?php echo $streamm['stream_name']; ?></td>
                    </tr>
                    <?php
                    $serial++;
                }
                ?>
            </table>
        </center>
    </div>
</body>

</html>