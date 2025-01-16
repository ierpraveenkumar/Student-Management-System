<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once ('database_connection.php');

if (isset($_POST['Add_Class'])) {
    $class_name = $_POST['class_name'];

    $checkClass = mysqli_query($data, "SELECT class_name FROM class WHERE class_name='$class_name'");
    if (mysqli_num_rows($checkClass) > 0) {
        $message = 'This class is already available. Please choose another.';
    } else {
        $sql = "INSERT INTO class (class_name) VALUES ('$class_name')";
        $result = mysqli_query($data, $sql);
        if ($result) {
            header('location:admin_view_class.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
    <?php
    include 'admin_css.php';
    ?>
    <style>
        .div_deg {
            background-color: skyblue;
            padding-top: 70px;
            padding-bottom: 70px;
            width: 500px;
        }
    </style>
</head>

<body>
    <?php
    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <h1>Add Class</h1>
            <br><br>
            <div class="div_deg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div>
                        <label for="">Class Name</label>
                        <input type="text" name="class_name">
                    </div>

                    <div>
                        <input class="btn btn_primary" type="submit" name="Add_Class">
                    </div>
                </form>
                <?php
                if (isset($message)) {
                    echo "<p style='color:red;'>$message</p>";
                }
                ?>
            </div>
        </center>
    </div>
</body>

</html>