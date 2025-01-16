<?php
session_start();
if(!isset($_SESSION['username'])){
header('location: login.php');
}
elseif($_SESSION['usertype']=='student'){
    header('location: login.php');
}

require_once('database_connection.php');


$sql="SELECT * FROM course";
$result=mysqli_query($data,$sql);



if($_GET['course_id']){
    $t_id=$_GET['course_id'];
    $sql2="DELETE FROM course   WHERE id='$t_id'";
    $result2=mysqli_query($data,$sql2);
    If($result2){
        header('location:admin_view_course.php');
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Teachers Data</title>
    <?php 
include 'admin_css.php';
    ?>




<style type="text/css">

.table_th{
    padding: 20px;
    font-size: 20px;
}
.table_td{
    padding: 20px;
    background-color: skyblue;
}
</style>
</head>
<body>
<?php
include 'admin_sidebar.php';
?>
<div class="content" >
    <center>
    <h1>View All Courses Data</h1>
    
    <table border="1px">
        <tr>
            <th class="table_th">Course Name</th>
            <th class="table_th">About Course </th>

            <th class="table_th">Course Image</th>
            <th class="table_th">Delete</th>
            <th class="table_th">Update</th>



        </tr>
<?php
while($info=$result->fetch_assoc()){


?>

        <tr>
            <td class="table_td"><?php
            echo "{$info['name']}";
            ?></td>
            <td class="table_td"><?php
            echo "{$info['description']}";
            ?></td>
            <td class="table_td"><img height="100px" width="100px" src="<?php
            echo "{$info['image']}";
            ?>" alt=""></td>


         <td class="table_td" >
        <?php 
        echo "
         <a onClick=\"javascript:return confirm('Are You Sure To Delete This')\" class='btn btn-danger' href='admin_view_course.php?course_id={$info['id']}'>Delete</a>
         ";
         ?>
        </td>



<td class="table_td">


<?php
echo "

<a class='btn btn-primary' href='admin_update_course.php?course_id={$info['id']}'>Update</a>
";
?>
</td>

        </tr>





        <?php
        }
        ?>
    </table>
    </center>
</div>

</body>
</html>