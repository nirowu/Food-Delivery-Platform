<?php
    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat"); 
    $nav_url = 'http://localhost/hw2/nav.php';
    if(isset($_POST['delete'])){
        $meal_id =$_POST['delete'];
        $sql = "UPDATE product SET exist = 0 WHERE PID=$meal_id;"; 
        $conn->query($sql);
    }
    // reset the primary key with correct order
    // seemed to be changed to a more efficient way
    // $del_id = "ALTER table `product` drop `PID`";
    // $new_id = "ALTER table `product` add `PID` mediumint( 8 ) not null first";
    // $set_id ="ALTER table `product` modify column `PID` mediumint( 8 ) not null auto_increment,add primary key(PID);";
    // $conn->query($del_id);
    // $conn->query($new_id);
    // $conn->query($set_id);
    echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";
?>