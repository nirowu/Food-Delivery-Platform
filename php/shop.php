<?php
    session_start();
    $validate = 0 ;
    $_SESSION['validate']= $validate;
    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat");
    $nav_url = 'http://localhost/hw2/nav.php'; 

    $shop_name = $_POST['shop_name'];
    $category = $_POST['category'];
    $latitude = $_POST['slatitude'];
    $longitude = $_POST['slongitude'];

    $sanitized_shop = mysqli_real_escape_string($conn, $shop_name);
    $sanitized_category = mysqli_real_escape_string($conn, $category);



    // echo"disabled:";
    // echo$_SESSION['disabled'];

    //check error
    $error = 0;
    $sql = "SELECT name FROM shop\n". "WHERE name='$sanitized_shop';";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $error +=1;
        echo "<script>
        alert('The shop has been registered.')
        </script>";
    }
    if($error > 0){
        echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";
        exit();
    }


    if(!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }
    else{
        // echo "connection success";
        $uid = $_SESSION['UID'];
        $stmt = $conn->prepare("INSERT INTO shop(name, longitude, latitude, phone_number, cate, UID) 
        VALUES('$sanitized_shop', '$longitude', '$latitude','{$_SESSION['phone_number']}' ,'$sanitized_category', $uid)");
        $execval = $stmt->execute();
        echo "<script>
        alert('Registion successfully....')
        </script>";
        // update user's identifier to manager
        
        $identifierSql = "UPDATE user SET identifier='manager' WHERE UID= $uid ";
        $_SESSION['identifier']='manager';
        $conn->query($identifierSql);

        $stmt->close();
        $conn->close();

        $validate = 1;
        $_SESSION['validate']= $validate;
        $_SESSION['shop_name']= $sanitized_shop;
        $_SESSION['category']= $category;
        $_SESSION['slatitude']= $_POST['slatitude'];
        $_SESSION['slongitude']= $_POST['slongitude'];

    
        echo$_SESSION['validate'];
        header( "Location: $nav_url" );
    }
    // change html 
    

  $conn->close();

?>
