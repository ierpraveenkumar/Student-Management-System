<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
    exit();
}

require_once ('database_connection.php');

if (isset($_GET['student_id'])) {
    $id = $_GET['student_id'];
}

$classsql = "SELECT * FROM class";
$classdata = mysqli_query($data, $classsql);

$streamsql = "SELECT * FROM stream";
$streamdata = mysqli_query($data, $streamsql);

$subjectsData = array();

// Initially fetch all subjects
$subject_data = mysqli_query($data, "SELECT * FROM subjects");
while ($sub = $subject_data->fetch_assoc()) {
    $subjectsData[$sub['class_id']][$sub['stream_id']] = json_decode($sub['subject_info'], true);
}

if (isset($_POST['add_subject'])) {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_name'];
    $stream_id = $_POST['stream_name'];

    if (isset($_POST['choose_subject'])) {
        $choose_subject = $_POST['choose_subject'];

        // $choose_subject is an array, encode it to JSON before inserting into the database
        $subjects_json = json_encode($choose_subject);

        $result_check_query = "SELECT * FROM st_choosed_subject WHERE student_id = $student_id LIMIT 1";
        $result = mysqli_query($data, $result_check_query);
        if ($result->num_rows > 0) {
            $_SESSION['exist_message'] = "Subjects Already Added .";
            header('location: admin_choose_subject.php');
            exit();
        } else {
            $sql2 = "INSERT INTO st_choosed_subject (student_id, class_id, stream_id, subjects) VALUES ($student_id, $class_id, $stream_id, '$subjects_json')";
            $result2 = mysqli_query($data, $sql2);
            if ($result2) {
                $_SESSION['success_message'] = "Subjects saved successfully!";
                header('location: admin_choose_subject.php');
                exit();
            }
        }
    } else {
        $_SESSION['none_select_message'] = "No Subject Selected";
        header('location: admin_choose_subject.php');

    }
}

// Handle AJAX request to fetch subjects
if (isset($_GET['class_id']) && isset($_GET['stream_id'])) {
    $class_id = $_GET['class_id'];
    $stream_id = $_GET['stream_id'];

    if (isset($subjectsData[$class_id][$stream_id])) {
        $subjects = $subjectsData[$class_id][$stream_id];
        $formattedSubjects = array();
        foreach ($subjects as $subject => $status) {
            $formattedSubjects[] = "$subject: $status";
        }
        echo json_encode($formattedSubjects);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

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
            width: 500px;
            padding-top: 70px;
            padding-bottom: 70px;
        }

        #choose_subject {
            width: 300px;
            height: 150px;
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
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
            <h1>Choose Subjects</h1>
            <br><br>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <div class="div_deg">
                    <div>
                        <input type="hidden" name="student_id" value="<?php echo $id; ?>">
                    </div>

                    <div>
                        <label for="">Choose Class</label>
                        <select name="class_name" id="class_name">
                            <?php while ($info = $classdata->fetch_array()) { ?>
                                <option value="<?php echo $info['id']; ?>"><?php echo $info['class_name']; ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="">Choose Stream</label>
                        <select name="stream_name" id="stream_name">
                            <?php while ($info1 = $streamdata->fetch_array()) { ?>
                                <option value="<?php echo $info1['id']; ?>"><?php echo $info1['stream_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="">Choose Subjects</label>
                        <select name="choose_subject[]" multiple id="choose_subject">
                            <!-- Subjects will be dynamically loaded here -->
                        </select>
                    </div>

                    <div>
                        <input class="btn btn-success" type="submit" name="add_subject" value="Submit">
                    </div>
                </div>

            </form>
        </center>
    </div>

    <script>
        document.getElementById("class_name").addEventListener("change", fetchSubjects);
        document.getElementById("stream_name").addEventListener("change", fetchSubjects);

        function fetchSubjects() {
            var class_id = document.getElementById("class_name").value;
            var stream_id = document.getElementById("stream_name").value;
            var selectElement = document.getElementById("choose_subject");

            selectElement.innerHTML = '';

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "<?php echo $_SERVER['PHP_SELF']; ?>?class_id=" + class_id + "&stream_id=" + stream_id, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var subjects = JSON.parse(xhr.responseText);

                    subjects.forEach(function (subject) {
                        var option = document.createElement("option");
                        option.text = subject;
                        option.value = subject.split(":")[0].trim();
                        selectElement.add(option);
                    });
                }
            };
            xhr.send();
        }

        fetchSubjects(); // Initial fetch on page load
    </script>

</body>

</html>