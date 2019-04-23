<?php 
session_start();
include "loo.php";

?>


<html>
<form action="" method="POST">
<input placeholder="username" type="text" id="w" name="name">
<br>
<br>

<input type="password" placeholder="password" name="password">
<br>
<br>
<input type="submit" name="submit" value="loin">
<br>
<br>
dont have an account ? you can <a href="sin.php">sign up</a> now



</form>
</html>
<?php 
$connection=mysqli_connect("localhost","root","","test");

if(!empty($_COOKIE['loinname'])&&!empty($_COOKIE['loinpassword'])){
    loin($_COOKIE['loinname'],$_COOKIE['loinpassword']);
}

if($_SESSION){

    if(array_key_exists("name",$_SESSION)){
if($_SESSION["name"]!=''&&$_SESSION["name"]!=null){
    header("location:main.php");
}}}



if(isset($_POST['submit'])){
   
    loin($_POST['name'],$_POST['password']);
    
}
function loin($name,$password){
    global $connection;
$read="SELECT * FROM `users`";
$reader=mysqli_query($connection,$read);

    while($row=mysqli_fetch_assoc($reader)){
        if($row["username"]==$name&&$row["password"]==$password){
            setcookie("loinname","$name",time()+3600);
            setcookie("loinpassword","$password",time()+3600);
            $_SESSION["name"]=$name;

        header("location:main.php");
        break;
                }
            }
            
            echo "wron username or password";
            
        }

if($_SESSION){
    if($_SESSION['up']=="true"){
        echo "<p style=color:#FFC300; >
        you have sign up successfully please loin</p>";
        $_SESSION['up']='';
    }}



?>
<script>
document.getElementById("w").focus();
</script>