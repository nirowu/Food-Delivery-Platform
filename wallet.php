<?php
session_start();
$dbservername = 'localhost';
$dbname = 'db_ubereat';
$dbusername = 'db_ubereat';
$dbpassword = 'dba833217';

if ( !isset( $_SESSION[ 'Authenticated' ] ) ||
$_SESSION[ 'Authenticated' ] != true )
 {
    header( 'Location: index.html' );
    exit();
}

$conn = new PDO( "mysql:host=$dbservername;dbname=$dbname",
$dbusername, $dbpassword );
# set the PDO error mode to exception
$conn->setAttribute( PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION );
?>
<?php
$money = $_POST[ 'addmoney' ];
$UID=$_SESSION['UID'];
$account=$_SESSION['account'];
$stmt = $conn->prepare( "UPDATE user SET wallet=(wallet+:money) WHERE UID=:UID");
$stmt->execute(array(
	'money' => $money,
	'UID' => $UID
) );
$stmt = $conn->prepare("INSERT INTO transaction (money, time, act, trader) VALUES (:money, NOW(), :act, :trader)");
        $stmt->execute( array(
            'money' => $money,
            'act' => "Recharge",
            'trader' => $account
) );
$_SESSION[ 'wallet' ] += $money;
echo' <script type="text/JavaScript"> alert("Recharge successful");</script> ';

?>
<form action="myordersrch.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="smystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
