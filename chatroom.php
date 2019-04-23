<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<?php
session_start();
include "loo.php";


$loin=$_SESSION['name'];
$connection=mysqli_connect("localhost","root","","test");
$to=$_GET['to'];


$isread="UPDATE notifications set isread=1 where reciver='$loin' and sender='$to' ";
mysqli_query($connection,$isread);

$read="SELECT * FROM `chatroom` where sender='$loin' or reciver='$loin'";
$reader=mysqli_query($connection,$read);


if($loin==''||$loin==null){
header("location:loin.php");}
$match=false;
if($to==''||$to==null){
die(header("location:main.php"));
}else{
    $readuser="SELECT * FROM `users`";
    $users=mysqli_query($connection,$readuser);
    while($row=mysqli_fetch_assoc($users)){
        if($row['username']==$to){
            $match=true;
            break;
        }
    }
    if(!$match){
        die("<h1 color=red>this account has been deleted 
        or it does not exists</h1>");
    }
}


if(isset($_POST['submit'])){
    date_default_timezone_set("Asia/Jerusalem");
    $date=date("Y-m-d H:i:s");
    if(!empty(trim($_POST['text']))){
        $text=$_POST['text'];
        $sql="INSERT INTO `chatroom` (`id`, `sender`, `reciver`,`text`,`date`) 
        VALUES (null , '$loin','$to','$text','$date')";
        $resulte=mysqli_query($connection,$sql);
        
        $notif="INSERT INTO `notifications` (`id`, `sender`, `reciver`,`isread`) 
        VALUES (null , '$loin','$to',0)";
        $resulte=mysqli_query($connection,$notif);}
    
    

    echo "<meta http-equiv='refresh' content='0'>";

}
?>

        <h1 style=" text-align: center; font-size: 5rem;"><?php echo $to;?></h1>
        <br>
        <br>
<?php


while($row=mysqli_fetch_assoc($reader)){
    if(($row['reciver']==$to)
    ||($row['sender']==$to)){
        $time=$row['date'];
        $time=time_elapsed_string("$time");
    if($row['sender']==$loin){
        ?>
        <div style=" width=50%; 
        border-left: 6px solid red;
        background-color: lightgrey;
        margin:1rem;
        word-wrap: break-word;
        padding:1rem;">
        <?php
        echo "<h3 style=
        'align:right;text-align: right;
        display:block;
       margin:auto;'> : you</h3><br>";
       echo "<h5
       style=
        'align:right;text-align: right;
        display:block;
        margin:auto;'>".$time."</h5><br>";
        echo "<h2
        style='width=50%; align:right;text-align: right;
        display:block; word-break: break-all;
        margin:auto;'
        >".$row['text']."</h2>";
        echo "<br>";
       
?>
        </div>
  <?php  
    }
        else{
            ?>
          <div style=" width=50%; 
        border-right: 6px solid red;
  background-color: lightgrey;
        margin:1rem;
        padding:1rem;
   word-wrap: break-word;">
            
            <?php
            echo "<p>".$row['sender']." : </p>";
            echo "<h5>".$time."</h5>";
            echo "<h2 style=' word-break: break-all;'>".$row['text']."</h2>";
            echo "<br>";
            
    }}
    ?>

    </div>
        <?php
}
?>
<form action="" method="post">
<input  autocomplete="off" style="width:100%; height:3rem;" id="w" type="text" 
name="text">
<input style="width:100%; height:2rem;" type="submit" name="submit">
</form>
<script>
window.scrollTo(0,document.body.scrollHeight);
    document.getElementById("w").focus();
</script>
<?php
















function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set("Asia/Jerusalem");
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


?>
