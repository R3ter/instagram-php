<?php
 date_default_timezone_set("Asia/Jerusalem");
 $date=date("Y-m-d H:i:s");
$name= $_POST['name'];
$connection=mysqli_connect("localhost","root","","test");
$readuser="SELECT * FROM `active`";
$found=false;
if(isset($_POST['name'])){
    $users=mysqli_query($connection,$readuser);
    while($row=mysqli_fetch_assoc($users)){
        if($row['name']==$name){
            $found=true;
        }
}
if($found){
    $qary="UPDATE `active` set date='$date' , isactive='active' where name='$name'";
    $resulte=mysqli_query($connection,$qary);
}else{
    $qary="INSERT INTO `active` (`name`, `isactive`,`date`) 
        VALUES ('$name','active','$date')";
        $resulte=mysqli_query($connection,$qary);
}
}

if(isset($_POST['out'])){
 $name=$_POST['out'];
    $qary="UPDATE `active` set date='$date' , isactive='inactive' where name='$name'";
    $resulte=mysqli_query($connection,$qary);
}

?>