<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<a href="main.php">
<h1 style="display:inline-block;" id="a">
WALEED'S SITE.COM</h1></a>

<?php 
  
  
 if(array_key_exists("name",$_SESSION)){
    if($_SESSION["name"]!=''&&$_SESSION["name"]!=null){
        $l=0;
        $match=false;
        $connection=mysqli_connect("localhost","root","","test");
        $loin=$_SESSION['name'];
        $sql="SELECT username from users";
        
        $reader=mysqli_query($connection,$sql);
       
        while($row=mysqli_fetch_assoc($reader)){
          
            if($row["username"]==$loin){
                $match=true;
                break;
            }
        }
        if(!$match){
            $_SESSION = array();
            setcookie('loinname', '', time() - 3600);
            setcookie('loinpassword', '', time() - 3600);
            session_destroy();
            header("location:loin.php");
        }

        $sql="SELECT * from notifications where reciver='$loin' and isread=0";
        $read=mysqli_query($connection,$sql);
        while($notifi=mysqli_fetch_row($read)){
            $l=$l+1;
        }

       ?>
    

<script>
$.ajax({
    url:'test.php',
    type:"POST",
    data:{name:'<?php echo $_SESSION['name']; ?>'}
})
// setTimeout( ()=>{location.reload();}, 6000*3);
</script>
       

       <?php
        echo  "<h2 style='float:right;' >welcome ".$_SESSION['name']." </h2>"; 
        echo "<br>";        
        if($loin!=''&&$loin!=null){
       

?>
    
<form action="" style="display:inline-block;
align:right; float:right;" method="post">
<input
style="border:none;
display:inline-block;
       background-color:red; 
       width:5rem;
       height:3rem;
      color:white;
       cursor:pointer;
       

"
 type="submit" value="lo off" name="off">
</form>

<?php if($l>0){ ?>
<p style="display:inline-block; background-color:#02B929;
    color:white;border-radius: 10px; padding:.31rem;"
  ><?php  echo $l; ?></p>
<?php } ?>
<a href="chat.php">
<input
style="border:none;
display:inline-block;
       background-color:yellow; 
       width:5rem;
       height:3rem;
       border-style: solid;
       border-color:blue;
       boarder-width:5rem;
       cursor:pointer;
       margin-right:1rem;

"
 type="submit" value="messae" name="chat"></a>
 <a href="main.php">
<input
style="border:none;
display:inline-block;
       background-color:yellow; 
       width:5rem;
       height:3rem;
       border-style: solid;
       border-color:blue;
       boarder-width:5rem;
       cursor:pointer;

"
 type="submit" value="Posts" name="chat"></a>

<br>
<br>
<br>



 <?php 
    }}
}else{
       echo  "<h2 style='float:right;' >Please loin</h2>"; 
       echo "<br>";         
    }


if(isset($_POST['off'])){
       $name=$_SESSION['name'];
       date_default_timezone_set("Asia/Jerusalem");
       $date=date("Y-m-d H:i:s");
    $qary="UPDATE `active` set date='$date' , isactive='inactive' where name='$name'";
    $resulte=mysqli_query($connection,$qary);
  
    $_SESSION = array();
    setcookie('loinname', '', time() - 3600);
    setcookie('loinpassword', '', time() - 3600);
    session_destroy();
    }
 
    


 ?> 






