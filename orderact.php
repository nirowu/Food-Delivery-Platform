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
$dist=$_SESSION['orderdist'];
$money=$_POST['totalmoney'];
$cate=$_POST['ordertype'];
$SID=$_SESSION['menusid'];
$UID=$_SESSION['UID'];
$username=$_SESSION[ 'account' ];
$stmt = $conn->prepare( "select name, uid from shop where sid=$SID" );
$stmt->execute( );
$row0 = $stmt->fetch();
$shopownerid=$row0['uid'];
$shopname=$row0['name'];
//$stmt = $conn->prepare( "select account from user where uid=$shopownerid" );
//$stmt->execute( );
//$row = $stmt->fetch();
//$shopowner=$row['account'];
		$stmt1 = $conn->prepare("INSERT INTO orders (status, start, dist, money, cate, SID, UID) VALUES (:status,  NOW(), $dist, $money, :cate, $SID, $UID)");
		$stmt1->execute( array(
		'status'=>"Not Finish",
		'cate'=>$cate
		));
		$oid = $conn->lastInsertId();
		$stmt = $conn->prepare("INSERT INTO transaction (money, time, act, trader) VALUES (:money, NOW(), :act, :trader)");
        $stmt->execute( array(
            'money' => $money,
            'act' =>"Payment",
            'trader' => $username
        ) );
		$stmt = $conn->prepare("INSERT INTO transaction (money, time, act, trader) VALUES (:money, NOW(), :act, :trader)");
        $stmt->execute( array(
            'money' => $money,
            'act' => "Receive",
            'trader' => $shopname
        ) );
		$stmt = $conn->prepare("UPDATE user SET wallet=(wallet-:money) WHERE UID=:UID");
        $stmt->execute( array(
            'money' => $money,
            'UID' => $UID
        ) );
		$stmt = $conn->prepare("UPDATE user SET wallet=(wallet+:money) WHERE UID=:UID");
        $stmt->execute( array(
            'money' => $money,
            'UID' => $shopownerid
        ) );

		for ($k = 0; $k < count($_POST['detailpid']); $k++)
{
			
			$pid=$_POST['detailpid'][$k];
			$amount=$_POST['orders'][$k];
			$price=$_POST['detailprice'][$k];
			 $stmt = $conn->prepare("INSERT INTO detail (OID, PID, price, amount) VALUES (:oid, :pid, :price, :amount)");
					$stmt->execute(array( 
						'oid' => $oid,
						'pid' => $pid,
						'price' => $price,
						'amount' => $amount
					));
					$stmt = $conn->prepare( 'UPDATE product SET quantity=(quantity-:amount) WHERE PID=:PID' );
					$stmt->execute( array(
						'amount' => $amount,
						'PID' => $pid
					) );
			
		}
		
echo' <script type="text/JavaScript"> alert("Order successful");</script> ';

?>
<form action="myordersrch.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="smystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
