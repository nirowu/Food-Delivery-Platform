<?php    
  session_start();

  $dbservername='localhost';
  $dbname='db_ubereat';
  $dbusername='db_ubereat';
  $dbpassword='dba833217';

  if (!isset($_SESSION['Authenticated']) ||
  $_SESSION['Authenticated']!=true)
  {
  header("Location: index.html");
  exit();
  }
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", 
  $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, 
  PDO::ERRMODE_EXCEPTION);
?>
<?php
//$start=date("Y-m-d H:i:s");
$UID=$_SESSION['UID'];
$oid=$_POST['oid'];
$sid=$_POST['sid'];
$username=$_SESSION[ 'account' ];
$money=$_POST['money'];
$stmt = $conn->prepare( "select status from orders where oid=:oid" );
$stmt->execute(array('oid' => $oid));
$row = $stmt->fetch();
$latest_status=$row['status'];
if($row['status']!="Not Finish"){
	echo' <script type="text/JavaScript"> alert("Cannot cancel the order.");</script> ';
}

$stmt = $conn->prepare( "select name, uid from shop where sid=$sid" );
$stmt->execute( );
$row0 = $stmt->fetch();
$shopownerid=$row0['uid'];
$shopname=$row0['name'];
if($latest_status=="Not Finish"){
$stmt = $conn->prepare( "UPDATE user SET wallet=(wallet-:money) WHERE uid=:UID");
$stmt->execute( array(
	'money' => $money,
	'UID' => $shopownerid
) );
$stmt = $conn->prepare( "UPDATE user SET wallet=(wallet+:money) WHERE uid=:UID");
$stmt->execute( array(
	'money' => $money,
	'UID' => $UID
) );
$stmt = $conn->prepare("UPDATE orders SET status=:status WHERE oid=:oid");
$stmt->execute( array(
	'oid' => $oid,
	'status' => "Cancel"
) );
$stmt = $conn->prepare("INSERT INTO transaction (money, time, act, trader) VALUES (:money, NOW(), :act, :trader)");
$stmt->execute( array(
	'money' => $money,
	'act' =>"Receive",
	'trader' => $username
) );
$stmt = $conn->prepare("INSERT INTO transaction (money, time, act, trader) VALUES (:money, NOW(), :act, :trader)");
$stmt->execute( array(
	'money' => $money,
	'act' => "Payment",
	'trader' => $shopname
) );

$stmt = $conn->prepare( "UPDATE product inner join detail on product.pid=detail.pid SET product.quantity=product.quantity+detail.amount WHERE detail.oid=$oid" );
$stmt->execute();
}?>
<form action="myordersrch.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="smystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
