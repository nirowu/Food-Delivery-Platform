<?php
    session_start();
    $dbservername='localhost';
    $dbname='db_ubereat';
    $dbusername='db_ubereat';
    $dbpassword='dba833217';
    $conn = new PDO("mysql:host=$dbservername; dbname=$dbname", $dbusername, $dbpassword);
    $sign_up_url = 'http://localhost/hw2/sign-up.html';
    $nav_url = 'http://localhost/hw2/nav.php';


// not considering sql injection cause input as select 

if(isset($_POST['TransSearch'])){
    if($_POST['TransSel']=="All"){
        echo"hello world";
        $sql = "SELECT * FROM `transaction`;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $_SESSION['TransRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    else {
        $sql = "SELECT * FROM transaction WHERE act=?;";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_POST['TransSel']]);
        $_SESSION['TransRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
header( "Location: $nav_url" );
// echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";

?>