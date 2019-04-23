<?php
session_start();
include "loo.php";?>

<?php 
$loin=$_SESSION['name'];
if($loin==''&&$loin==null){
    die(
        header("location:loin.php")  
    );
}else{
    $id=$_GET['id'];

    date_default_timezone_set("Asia/Jerusalem");
    $date=date("d/m/Y||_||h:i-a");

    $connection=mysqli_connect("localhost","root","","test");
    $read = "SELECT * FROM `photo` where id=$id";
    $reader=mysqli_query($connection,$read);
    $row=mysqli_fetch_assoc($reader);
    if($row['photo']==""||$row['photo']==null){
       die(
          "<h1>sorry this post is no loner
          available <a href=main.php>o back</a></h1>"
       );
        
    }
    $url =base64_encode( $row['photo'] );

    $readcomments="SELECT * FROM `commecnts` where post=$id ORDER BY `commecnts`.`id` DESC ";
    $commentsreader=mysqli_query($connection,$readcomments);
    
    

    ?>
    <div style="align:center; display: inline; align-text:center;">
    <h1 style="align:center;text-align: center;">
    <?php echo $row['name']; ?>
    </h1>
    <h5 style="align:center;text-align: center;"><?php echo 
    $date=str_replace("||_||","<br><br>",$date); ?></h5>
    <p style="align:center;text-align: center;">
    <?php echo $row['text'];?>
    </p>
    <img
    style="width:50rem; align:center;text-align: center;
     display:block;
    margin:auto;
    "
     src=data:image/jpeg;base64,<?php echo $url; ?> />
    </div>
    <br>
    <br>
    <br>
    <div  >
    <form method="post"  >
    <input type="text" name="text" 
    autocomplete="off"
    style=" height:2rem; margin:1rem; width:90%; " >
    <input type="submit" name="submit" style=" height:3rem;
     margin-left:1rem; margin-right:1rem;width:90%;" value="Add a Comment" >
    </form>
    </div>
    <?php 
    if(isset($_POST['submit'])&&!empty(trim($_POST['text']))){
        
        $likes="SELECT comments FROM `photo` where id=$id";
        $likes=mysqli_query($connection,$likes);
        $likes=mysqli_fetch_assoc($likes);
        $likes=$likes['comments']+1;
           mysqli_query($connection,"UPDATE photo SET 
           comments='$likes' WHERE id=$id");
    

        $comment=$_POST['text'];

        $qary="INSERT INTO `commecnts` (`id`, `name`, `text`,`likes`,`post`,`date`,`names`) 
    VALUES (null , '$loin', '$comment' ,0,'$id','$date',' ')";
    $resulte=mysqli_query($connection,$qary);
    echo "<meta http-equiv='refresh' content='0'>";

    }

    while($row=mysqli_fetch_assoc($commentsreader)){
     ?>
     <div style="background-color:#91FFCA; 
     word-break: break-all;
     padding:1rem;
     margin:1rem;">
     <h2 style="display:inline-block"><?php echo $row['name'] ?> </h2>
     <h5 style="display:inline-block; float:right" >
     <?php echo $date=str_replace("||_||","<br><br>",$date); ?> </h5>
     <h3><?php echo $row['text'] ?> </h3>
     <form method="post" >
     <input type="text" 
     style="width:0rem; height:0rem;"
     readonly hidden
      name="id" value=<?php echo $row['id'] ?> >
      
     <input type="submit" name="like" value=<?php 
      if(strpos($row['names'],$loin)!==false){
         echo "Unlike";
     }else{echo "like";} ?> >
     <?php 
     if($loin==$row['name']){
         ?>
         <input type="submit" name="delete" value="delete"> 
                 <?php
     }
     ?>
     </form>
     <p color="#00FF84"
     title=<?php echo $row['names'];?>
     >+ <?php echo $row['likes']; ?></p>
     </div>
     <?php  
    }
    if(isset($_POST['delete'])){
        $idcomment=$_POST['id'];
        mysqli_query($connection,"DELETE from `commecnts` where id=$idcomment"); 
        $likes=$likes['comments']-1;
           mysqli_query($connection,"UPDATE photo SET 
           comments='$likes' WHERE id=$id"); 
        echo "<meta http-equiv='refresh' content='0'>";

    }
        if(isset($_POST['like'])){
            
         $idcomment=$_POST['id'];
         $likes="SELECT * FROM `commecnts` where id=$idcomment";
         $likes=mysqli_query($connection,$likes);
         $likes=mysqli_fetch_assoc($likes);

         if(strpos($likes['names'],$loin.',')!==false){
         $like=$likes['likes']-1;
         $names=str_replace($loin.',','',$likes['names']);
         
        }else{
            $like=$likes['likes']+1;
            $names=$loin.",".$likes['names'];
           
        }
        
       
        
        mysqli_query($connection,"UPDATE commecnts SET likes=$like , names='$names' WHERE id=$idcomment");
        
        echo mysqli_error($connection);
         
            
         echo "<meta http-equiv='refresh' content='0'>";
         
         
         
        
        
    }
}






?>