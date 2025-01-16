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
require_once ('database_connection.php');

$id = $_SESSION['userid'];
$username = $_SESSION['names'];

$sql = "SELECT s.*, u.name
        FROM st_choosed_subject s
        INNER JOIN user u ON s.student_id = u.id WHERE s.student_id= $id";
$result = mysqli_query($data, $sql);

// Fetch the first row
$info = $result->fetch_assoc();

// Check if the marks column is null
if (is_null($info['marks'])) {
  $message = "Wait for admin to add the result and then check again.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Result</title>
  <?php
  include 'student_css.php';
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
  include 'student_sidebar.php';
  ?>
  <div class="content">
    <center>
      <h2>View Your Result Mr <?php echo $username; ?></h2>

      <?php if (isset($message)) {
        echo "<p>$message</p>";
      } else { ?>
        <table border="1px">
          <tr>
            <th class="table_th">Student Name</th>
            <?php
            // Fetch unique subjects from the first row
            $subjects = json_decode($info['subjects'], true);
            foreach ($subjects as $subject) {
              echo "<th class='table_th'>$subject</th>";
            }
            echo "<th class='table_th'>Percentage</th>";
            echo "<th class='table_th'>Result Status</th>";
            echo "<th class='table_th'>Year</th>";
            ?>
          </tr>
          <?php
          $marks = json_decode($info['marks'], true);
          $totalMarks = array_sum($marks);
          $percentage = ($totalMarks / (count($marks) * 100)) * 100;
          $resultStatus = '';
          $date = date('d-m-y');
          if ($percentage >= 60) {
            $resultStatus = 'First';
          } elseif ($percentage >= 50) {
            $resultStatus = 'Second';
          } elseif ($percentage >= 33) {
            $resultStatus = 'Pass';
          } else {
            $resultStatus = 'Fail';
          }
          ?>
          <tr>
            <td class="table_td"><?php echo "{$info['name']} (user_id)={$info['student_id']}"; ?></td>
            <?php
            foreach ($marks as $mark) {
              echo "<td class='table_td'>$mark</td>";
            }
            echo "<td class='table_td'>".round($percentage,2)."%</td>";
            echo "<td class='table_td'>$resultStatus</td>";
            echo "<td class='table_td'>$date</td>";
            ?>
          </tr>
        </table>
      <?php } ?>
    </center>
  </div>
</body>

</html>
