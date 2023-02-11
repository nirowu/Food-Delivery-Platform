<?php
    // $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat");
    session_start();
    $dbservername='localhost';
    $dbname='db_ubereat';
    $dbusername='db_ubereat';
    $dbpassword='dba833217';
    $conn = new PDO("mysql:host=$dbservername; dbname=$dbname", $dbusername, $dbpassword);
    $nav_url = 'http://localhost/hw2/nav.php';

    echo "hello world";

    $order_id = $_SESSION['OID'];
    $OrderSql = "SELECT * FROM detail WHERE OID=?;";
    $stmt = $conn->prepare($OrderSql);
    $stmt->execute([$order_id]);
    $_SESSION['SorderDetail'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo $_SESSION['SorderDetail'];
    // header( "Location: $nav_url" );
    echo "<meta http-equiv='Refresh' content='3;URL=$nav_url'>";
?>