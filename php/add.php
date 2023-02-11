<?php
    session_start();
    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat");
    $nav_url = 'http://localhost/hw2/nav.php';
    $meal_name = $_POST['meal_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];//

    $sanitized_meal = mysqli_real_escape_string($conn, $meal_name);
    $sanitized_price = mysqli_real_escape_string($conn, $price);
    $sanitized_quantity = mysqli_real_escape_string($conn, $quantity);

    //check error
    $error = 0;
    $sql = "SELECT name FROM product\n". "WHERE name='$meal_name';";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $error +=1;
        echo "<script>
        alert('The meal has been on the list.')
        </script>";
    }
    if($error > 0){
        echo "<meta http-equiv='Refresh' content='0;URL= $nav_url'>";
        exit();
    }

    // insert into database(product)
    if(!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }
    else{
        $file = fopen($_FILES["myFile"]["tmp_name"], "rb");

        $fileContents = fread($file, filesize($_FILES["myFile"]["tmp_name"])); 
        fclose($file);
        $fileContents = base64_encode($fileContents);
        // echo $fileContents;
        $imgType=$_FILES["myFile"]["type"];

        $temp = $_SESSION['shop_name'];
        echo $temp;
        $sql_0="SELECT * FROM shop\n". "WHERE name='$temp';";
        $result = $conn->query($sql_0);
        $row =$result->fetch_assoc();
        // echo "sid";
        $sid= $row['SID'];
        $_SESSION['SID']=$sid;
        echo $sid;
        // echo $sid;
        $exist = 1;
        $sql_1="INSERT INTO product (SID, name, price, quantity, pic, pic_type, exist) VALUES ('$sid','$sanitized_meal', '$sanitized_price', '$sanitized_quantity','$fileContents','$imgType','$exist')";
        $conn->query($sql_1);
    }
    echo "<meta http-equiv='Refresh' content='0;URL= $nav_url'>";
    // NEED TO RESIZE THE PICTURE SIZE

?>