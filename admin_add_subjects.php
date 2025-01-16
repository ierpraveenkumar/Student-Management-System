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

$classResult = mysqli_query($data, "SELECT * FROM class");
$streamResult = mysqli_query($data, "SELECT * FROM stream");
$subjectDataResult = mysqli_query($data, "SELECT * FROM subject_table");

$class = [];
$stream = [];
$subjectData = [];

while ($info = $classResult->fetch_assoc()) {
    $class[] = $info;
}

while ($info = $streamResult->fetch_assoc()) {
    $stream[] = $info;
}

while ($info = $subjectDataResult->fetch_assoc()) {
    $subjectData[] = $info;
}

if (isset($_POST['Add_Subjects'])) {
    $class_id = $_POST['class_id'];
    $stream_id = $_POST['stream_id'];
    $selectedSubjects = $_POST['selectedSubjects'];
    $subjectTypes = $_POST['subjectType'];

    $subjectDataArray = [];
    foreach ($selectedSubjects as $subject) {
        $type = $subjectTypes[$subject];
        $subjectDataArray[$subject] = $type;
    }

    $subjects_json = json_encode($subjectDataArray);

    // Check if subjects already exist for the selected class and stream
    $checkSubjects = mysqli_query($data, "SELECT * FROM subjects WHERE class_id='$class_id' AND stream_id='$stream_id'");
    if (mysqli_num_rows($checkSubjects) > 0) {
        $message = 'These subjects already exist for the selected class and stream.';
    } else {
        $sql = "INSERT INTO subjects (stream_id, class_id, subject_info) VALUES ('$stream_id', '$class_id', '$subjects_json')";
        $result = mysqli_query($data, $sql);
        if ($result) {
            header('location: admin_view_subjects.php');
            $_SESSION['sub_save_success']="Subjects Added Successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subjects</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .div_deg {
            background-color: skyblue;
            padding-top: 70px;
            padding-bottom: 70px;
            width: 500px;
        }

        .div_deg {
            background-color: skyblue;
            padding: 20px;
            width: 500px;
            height: 300px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Add Subjects</h1>
            <?php
            if (isset($message)) {
                echo "<p style='color:red;'>$message</p>";
            }
            ?>
            <br><br>
            <div class="div_deg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label for="class_id">Select Class:</label>
                        <select name="class_id">
                            <?php foreach ($class as $info) { ?>
                                <option value="<?php echo $info['id']; ?>"><?php echo $info['class_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label for="stream_id">Select Stream:</label>
                        <select name="stream_id">
                            <?php foreach ($stream as $info) { ?>
                                <option value="<?php echo $info['id']; ?>"><?php echo $info['stream_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label for="subjects">Choose Subjects:</label>
                        <div style="height: 200px; overflow-y: scroll;">
                            <?php foreach ($subjectData as $info) { ?>
                                <input type="checkbox" name="selectedSubjects[]"
                                    value="<?php echo $info['subject_name']; ?>">
                                <label><?php echo $info['subject_name']; ?></label>
                                <input type="radio" name="subjectType[<?php echo $info['subject_name']; ?>]"
                                    value="compulsory">
                                Compulsory
                                <input type="radio" name="subjectType[<?php echo $info['subject_name']; ?>]"
                                    value="optional">
                                Optional
                                <br>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <input class="btn btn_primary" type="submit" name="Add_Subjects" value="Add Subjects">
                    </div>
                </form>

            </div>
        </center>
    </div>
</body>

</html>