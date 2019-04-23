<?php 
session_start();
include "loo.php";
?>

<html>


<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="photo">
<br>
<br>
<br>
<input autocomplete ="off" type="text" name="text" 
placeholder="what do you want to say..." 
style="width: 30rem; height:3rem;"
>
<input type="submit" name="submit" 
value="Post"
style="width: 5rem; height:3rem;">
</form>

</html>


<?php



$loin=$_SESSION['name'];


if($loin!=''&&$loin!=null){
    $connection=mysqli_connect("localhost","root","","test");
    $read="SELECT * FROM `photo` ORDER BY `photo`.`id` DESC";

    if($connection){
        $reader=mysqli_query($connection,$read);
        
       while($row=mysqli_fetch_assoc($reader)){
            if($row){
                $url=base64_encode( $row['photo'] );
                ?>
                <div 
                

                title=<?php 
                echo $row['date'];
                ?>
                style="
                width:25%;
                margin:1rem;
                padding:1rem;
                display: inline-block;
                border-style: solid;
                border-width: 5px;
                border-color:blue;
                border-radius: 3rem;
                ">
                <a 
                style="text-decoration: none;"
                href="comments.php?id=<?php echo $row['id']; ?>">

              <h2 style="color:00FF08;
                    margin: 0 auto;
                    text-align: center;  
                    margin-bottom:2rem;
               ">
              <?php echo $row['name'];?> 
              </h2>
                <p style="word-break: break-all;
                 color:red;"><?php echo $row['text']; ?> </p>
                
                <img 
                height=350rem
                style="width:100%;
                 padding:1rem;
                align:center;
                "
                src=data:image/png;base64,<?php echo $url; ?> 
                />
                </a>
                <form style="display:inline-block;"
                 method="post">
                <input type="text" name="id"
                readonly hidden
                 value=<?php echo $row['id']; ?> >
                 
                <?php
                if(strpos($row['names'],$loin)!== false){?>
                 <input 
                 style="background-color:red;border:none;
                 color:white;padding:.5rem;
                 border-radius:2rem;cursor:pointer;"
                 type="submit" name="like" value="unlike">
                 <?php
                }else{
                    ?>
                  <input 
                 style="background-color:green;border:none;
                 color:white;padding:.5rem;
                 border-radius:2rem;cursor:pointer;"
                 type="submit" name="like" value="like">
                 <?php
                }
                ?>
                
                </form>
                <p style="color:green;
                         display:inline-block;"> +<?php 
                 echo $row['likes'];
                ?> </p>
                <p style="color:green;
                         display:inline-block;"> ,Comments <?php 
                 echo $row['comments'];
                ?> </p>
                 <p style="display:inline-block;float:right">Size: <?php echo (int) ($row['size']/1024); ?> KB</p>
                <?php if($loin==$row['name']){
                    ?>
                    <form action="" method="post"  style="margin-left:.5rem;">
                    
                    <input readonly hidden
                    type="text" value=<?php echo $row['id'];?> name="postid">
                    <input type="submit" name="delete" value="Delete">
                    </form>
                    <?php 
                }
                ?>

                </div>
            <?php
              }
    
        }
     
        
    }else{
        die("error");
    }
   
    if(isset($_POST['delete'])){
       $postid=$_POST['postid'];
       $delete="DELETE from photo where id=$postid";
       mysqli_query($connection,$delete);
        // die(mysqli_error($connection));
        echo "<meta http-equiv='refresh' content='0'>";
    }

if(isset($_POST['like'])){
    $name=$loin;
    $idcomment=$_POST['id'];
    $likes="SELECT likes FROM `photo` where id=$idcomment";
    $names="SELECT names FROM `photo` where id=$idcomment";
    $likes=mysqli_query($connection,$likes);
    $likes=mysqli_fetch_assoc($likes);
    
    $names=mysqli_query($connection,$names);
    $names=mysqli_fetch_assoc($names);
    $names=$names['names'];
    echo $names;
    if(strpos($names,$name.',')!== false){
        $likes=$likes['likes']-1;
        $names=str_replace($name.',', "", $names);
    }else{
        $names=$names.$name.',';
        $likes=$likes['likes']+1;    
        }

    $d=mysqli_query($connection,"UPDATE photo SET 
    likes=$likes , names='$names' WHERE id=$idcomment");
    
    echo "<meta http-equiv='refresh' content='0'>";
    
}
if(isset($_POST['submit'])){
    date_default_timezone_set("Asia/Jerusalem");
    $date=date("d/m/Y||_||H:i-a");
    $text=$_POST['text'];
    $text=filter_var($text, FILTER_SANITIZE_STRING);
    if (!file_exists($_FILES['photo']['tmp_name'])
     || !is_uploaded_file($_FILES['photo']['tmp_name'])){
        echo "<script>
        alert('you have to select an im to upload')
        </script>";
       


    }else{
    if($_FILES['photo']['size']>81920){
        echo "<script>
        alert('your file cant be bier than 80KB')
        </script>";
    }else{
    $filename=$_FILES['photo']['name'];
    if(pathinfo($filename, PATHINFO_EXTENSION)=="png"||
    pathinfo($filename, PATHINFO_EXTENSION)=="jpg"||
    pathinfo($filename, PATHINFO_EXTENSION)=="gif"){
    if($_FILES["photo"]["tmp_name"]!=""&&
    $_FILES["photo"]["tmp_name"]!=null
    &&$_FILES["photo"]["size"]>100){
        $photo=addslashes(file_get_contents($_FILES["photo"]["tmp_name"]));
        echo $photo;
        $size=$_FILES["photo"]["size"];   
        $qary="INSERT INTO `photo` (`photo`, `name`, `size`,`id`,`text`,`date`
        ,`likes`,`comments`,`names`) VALUES ('$photo' , '$loin', $size ,null,'$text','$date',0,0,' ')";
    $resulte=mysqli_query($connection,$qary);
    if(!$resulte){
        die(mysqli_error($connection));
    }
    }
  

    
}else{
    echo "<script>
    alert('file can only have png or jpg or gif extension')
    </script>";
}
}
}
echo "<meta http-equiv='refresh' content='0'>";
}
}else{
    die(
        header("location:loin.php")
        
    );
}
 

?>