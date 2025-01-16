<?php
session_start();
if($_SESSION['message']){
    $message=$_SESSION['message'];
    echo " <script type='text/javascript' > alert('$message') </script>";
    unset($_SESSION['message']);
}

require_once('database_connection.php');


$sql="SELECT *FROM teacher";
$result=mysqli_query($data,$sql);



$sql2="SELECT *FROM course";
$result2=mysqli_query($data,$sql2);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International English And Science School Charakmara - Where Learning Begins</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <nav> 
        <label class="logo">International English And Science School Charakmara</label>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#course">Courses</a></li>
            <li><a href="#admission">Admission</a></li>
            <li><a href="login.php" class="btn btn-success">Login</a></li>
            <li><a href=<?php
            if ($_SESSION['usertype']=="student"){
               echo "studenthome.php";
                }
                else{
                    echo "adminhome.php";
                } ?> class="btn btn-primary">Dashboard</a></li> <!-- Add this line -->

        </ul>
    </nav>
    <div id="home" class="section1">
        <label class="img-text">Welcome to International English And Science School Charakmara - Where Learning Begins</label>
        <img class="main_img" src="https://c1.wallpaperflare.com/preview/968/730/441/building-cheyenne-photos-high-school.jpg">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img alt="2ndImg" style="height: 260px; width: 300px;" class="welcome-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaldHuWFherOyNBLi95KrNSXNlCUs9WiPdPUh13KUBLSZh0jYOrrd_vnqGPkfgJqdyZFo&usqp=CAU">
            </div>
            <div class="col-md-8">
                <h1>Welcome to Your School</h1>
                <p>At Our School, we are committed to providing quality education that nurtures young minds, ignites creativity, and empowers students to reach for their dreams. Our journey together is one of knowledge, growth, and endless possibilities, shaping a brighter future for all.</p>
            </div>
        </div>
    </div>

    <center> <h1 style="background-color: yellowgreen;">Meet Our Dedicated Teachers</h1></center>

    <div id="teacher" class="container">
        <div class="row">
        <?php
        while($info=$result->fetch_assoc()){

     
        ?>
            <div class="col-md-4">
                <img class="teacher" src="<?php echo "{$info['image']}"; ?>">

                <h3> <?php echo "{$info['name']}"; ?> </h3>

                <h5> <?php echo "{$info['description']}"; ?> </h5>

            </div>
            <?php
        }
            ?>
            
        </div>
    </div>

    <center> <h1 style="background-color: yellowgreen;">Explore Our Courses</h1></center>

    <div id="course" class="container">
        <div class="row">
        <?php
        while($info=$result2->fetch_assoc()){

     
        ?>
            <div class="col-md-4">
                <img class="teacher" src="<?php echo "{$info['image']}"; ?>">

                <h3> <?php echo "{$info['name']}"; ?> </h3>

                <h5> <?php echo "{$info['description']}"; ?> </h5>

            </div>
            <?php
        }
            ?>
            
        </div>
    </div>
    <center> <h1 style="background-color: yellowgreen;" class="adm"> Admission Form</h1></center>

    <div id="admission" align="center" class="admission_form">
        <form action="process_application.php" method="post">
            <div class="adm_int" >
                <label class="label_text" >Name</label>
                <input class="input_deg" type="text" name="name" required>
            </div>
            <div class="adm_int">
                <label class="label_text">Email</label>
                <input class="input_deg" type="email" name="email" required>
            </div>
            <div class="adm_int">
                <label class="label_text">Phone</label>
                <input class="input_deg" type="text" name="phone" required>
            </div>
            <div class="adm_int">
                <label class="label_text">Message</label>
                <textarea class="input_txt" name="message" id="" required></textarea>
            </div>
            <div class="adm_int">
                <input class="btn btn-primary" id="submit" value="Apply" type="submit" name="apply">
            </div>
        </form>
    </div>

    <footer>
        <h3 class="footer_text" >&copy; All rights reserved by International School of English And Science Charakmara</h3>
    </footer>
</body>
</html>
