<?php 
session_start();
include "loo.php";
?>
<!-- <form action="" method="get">
<input type="text" name="search" placeholder="search" >
<input type="submit" name="submit" value="Search">
</form> -->
<?php
$l=0;
if(array_key_exists("name",$_SESSION)){
    if($_SESSION["name"]==''||$_SESSION["name"]==null){
      die(header("location:main.php"));
    }}else{
      die(header("location:main.php"));
    }
    $loin=$_SESSION['name'];

$connection=mysqli_connect("localhost","root","","test");
$read="SELECT * FROM `users`";
$reader=mysqli_query($connection,$read);

$names=0;
echo "<h2>Click on the username you want to send a messae to :</h2>";
while($row=mysqli_fetch_assoc($reader)){

    if($row['username']==$loin){
        continue;
    }
    // if(!empty($_GET['search'])){
    //     $match=similar_text($_GET['search'],$row['username']);
    //     if(strpos($_GET['search'],$row['username'])!==false
    //     ||$match>4){
    //         $names=$names+1;
    //        ?>
    <!--     <a style="text-decoration: none;"
    //     href="chatroom.php?to=<?php echo $row['username'];?>">
    //    <h1 style="display:inline-block;">
    //    <?php echo $row['username'];?></h1>
    //    </a>
        <br> 
    //    <?php
    //    }
    // }else{
        $names=$names+1;    
    ?>
    !-->
    <?php
    $name=$row['username'];
    $sql="SELECT * from `active` where name='$name'";
    $active=mysqli_query($connection,$sql);
    $active=mysqli_fetch_assoc($active);
    date_default_timezone_set("Asia/Jerusalem");
    $date1 = new DateTime($active['date']);
    $date2 = new DateTime;
    $diff = $date1->diff($date2);
    
    $sql="SELECT * from notifications where reciver='$loin' and isread=0 and sender='$row[username]'";
        $read=mysqli_query($connection,$sql);
        while($notifi=mysqli_fetch_row($read)){
            $l=$l+1;
        }
    if($l>0){
        ?>
        <p style="display:inline-block; background-color:#02B929;
    color:white;border-radius: 10px; padding:.31rem;"
        ><?php echo $l; ?></p>
        <?php
    }

    ?>
    
    <a style="text-decoration: none;"
     href="chatroom.php?to=<?php echo $row['username'];?>">
    <h1 style="display:inline-block;">
    <?php echo $row['username'];
    ?></h1>
    </a>
    <?php 
    if($diff->i<2&&$active['isactive']=="active"){
        ?>
        <p style="display:inline-block; background-color:green;
    color:white;border-radius: 10px; padding:.31rem;">
    active
    </p>
    <br>
        <?php
    }else{
    ?>
    <p style="display:inline-block; background-color:red;
    color:white;border-radius: 10px; padding:.31rem;">
    <?php
    if($diff->m>=1){
        echo "was active ".$diff->m."  Months ao" ;}
        elseif($diff->d>=1){
            echo "was active ".$diff->d."  days ao";}
            elseif($diff->h>=1){
                echo "was active ".$diff->h."  Hours ao";}
                elseif($diff->i>=1){
                    echo "was active ".$diff->i."  Min ao";}
                    elseif($diff->s>=1){
                        echo "was active ".$diff->s."  sec ao";}
                    
                    
?>
</p>
    <br>
    <?php
    }
    $l=0;
}
        if($names==0){
            echo "<h2>no one was found </h2>";
        }else{
            echo "<h2>$names users was found</h2>";
        }


   


?>