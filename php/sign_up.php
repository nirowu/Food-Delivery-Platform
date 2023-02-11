<?php
    //database connection
    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat");
    $sign_up_url = 'http://localhost/hw2/sign-up.html';
    $nav_url = 'http://localhost/hw2/nav.php';

    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $account = $_POST['account'];
    $password = $_POST['password'];
    $re_passwd = $_POST['re_passwd'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    session_start();
    $_SESSION['name']= $_POST['name'];
    $_SESSION['phone_number']= $_POST['phone_number'];


    // Check connection
    if (!$conn) {
        die("Connection failed: " .mysqli_connect_error());
    }
    else{
        
        // sanitized string avoiding sql_injection
        $sanitized_name = mysqli_real_escape_string($conn, $name);
        $sanitized_account = mysqli_real_escape_string($conn, $account);
        $sanitized_password = mysqli_real_escape_string($conn, $password);
        $sanitized_repasswd = mysqli_real_escape_string($conn, $re_passwd);

        // error detection
        $error = 0;
        if($password !== $re_passwd){
            $error +=1;
            echo "<script>
            alert('Password and confirm password does not match.')          
            </script>";
        }
        $sql = "SELECT account FROM user\n". "WHERE account='$sanitized_account';";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $error +=1;
            echo "<script>
            alert('The account has been registered.')
            </script>";
        }
        if($error>0){
            echo "<meta http-equiv='Refresh' content='0;URL=$sign_up_url'>";
            exit();
        }

        // connect to database
        $hashed_passwd = hash('sha256', $sanitized_password);
        $user ="user";
        $zero = 0;
        $stmt = $conn->prepare("INSERT INTO user (account, password, identifier, name, longitude, latitude, phone_number, wallet) 
                                VALUES('$sanitized_account', '$hashed_passwd','$user', '$sanitized_name', '$longitude', '$latitude', '$phone_number','$zero')");
        $execval = $stmt->execute();
        echo "<script>
        alert('Registion successfully....')
        </script>";
        echo $execval;
        $stmt->close();
        $conn->close();

        // jump to home page
        
        echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";

    }


?>
