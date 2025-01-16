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

if (isset($_POST['Add_Stream'])) {
    $stream_name = $_POST['stream_name'];

    $checkStream = mysqli_query($data, "SELECT stream_name FROM stream WHERE stream_name='$stream_name'");
    if (mysqli_num_rows($checkStream) > 0) {
        $message = 'This stream is already available. Please choose another.';
    } else {
        $sql = "INSERT INTO stream (stream_name) VALUES ('$stream_name')";
        $result = mysqli_query($data, $sql);
        if ($result) {
            header('location:admin_view_stream.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stream</title>
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
            <h1>Add Stream</h1>
            <br><br>
            <div class="div_deg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div>
                        <label for="">Stream Name</label>
                        <input type="text" name="stream_name">
                    </div>

                    <div>
                        <input class="btn btn_primary" type="submit" name="Add_Stream">
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