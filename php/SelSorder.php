<?php
    session_start();
    $dbservername='localhost';
    $dbname='db_ubereat';
    $dbusername='db_ubereat';
    $dbpassword='dba833217';
    $conn = new PDO("mysql:host=$dbservername; dbname=$dbname", $dbusername, $dbpassword);
    $sign_up_url = 'http://localhost/hw2/sign-up.html';
    $nav_url = 'http://localhost/hw2/nav.php';

    if(isset($_POST['SorderSearch']) && $_SESSION['identifier']=="manager"){
        if($_POST['SorderSel']=="SorderAll"){
            $sql = "SELECT * FROM `orders`;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $_SESSION['SorderRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $sql = "SELECT * FROM orders WHERE status=?;";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_POST['SorderSel']]);
            $_SESSION['SorderRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    header( "Location: $nav_url" );
?>