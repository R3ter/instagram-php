<?php
            session_start();
            include "loo.php";
            if($_SESSION){

                if(array_key_exists("name",$_SESSION)){
            if($_SESSION["name"]!=''&&$_SESSION["name"]!=null){
                header("location:main.php");
            }}}
            
            ?>

<form action="" method="post">
<input placeholder="username" type="text" name="name">
<br>
<br>
<input placeholder="password" type="password" name="password">
<br>
<br>
<input placeholder="re-password" type="password" name="re-password" >
<br>
<br>
<input placeholder="E-mail" type="email" name="email" >
<br>
<br>
<input type="submit" name="submit" value="Sign up">
</form>
have an accounr already ?
<a href="loin.php">sign in</a>
<br>
<br>
<?php
$connection=mysqli_connect("localhost","root","","test");
$read="SELECT * FROM `users`";
$reader=mysqli_query($connection,$read);
$match=false;

if(isset($_POST['submit'])){
   if(!empty($_POST['name'])&&!empty($_POST['password'])&&
   !empty($_POST['email'])&&!empty($_POST['re-password'])){
    $name=$_POST['name'];
    $name = str_replace(' ','',$name);
   $password=$_POST['password'];
   $email=$_POST['email'];
   if(strlen($name)>=6){
   while($row=mysqli_fetch_assoc($reader)){
    if($row["username"]==$name){
        $match=true;
        break;
    }
}
} else{
    echo "* your name should be 6 char at least <br>";
}
if(!$match){
    if($password==$_POST['re-password']){
        if(strlen($password)<=6){
            echo "<p>* password is too short</p>";
        }else{
            if(preg_match("/^[a-zA-Z0-9]+$/", $name)){
            $random=rand(1000,10000);
            $qary="INSERT INTO `users` (`id`, `username`, `password`,`email`,`random`) 
            VALUES (NULL, '$name', '$password','$email','$random')";
            $resulte=mysqli_query($connection,$qary);
            $_SESSION['up']="true";
            header("location:loin.php");
            $mail="you have sign up successfully still 
            you are one step ahead please 
            enter this code $random  so you can sign in";
            mail("$email","welcome to chat.com",$mail);
            }else{
                echo "<p>* user name can only contain letters and numbers</p>";
            }
        }
}
    else{
        echo "<p>* passwords does not match </p>";
    }
}else{
    echo '<p style="color:red">username is already taken</p>';
}
}else{
    echo "<p>* fill all the blanks</p>";
}
}
