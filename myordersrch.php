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
$uid=$_SESSION['UID'];

    if(!empty($_POST['smystatus']))
    {
		if($_POST['smystatus']=="all"){
			$stmt = $conn->prepare("select shop.name, orders.oid, orders.status, orders.start, orders.end, orders.money, orders.sid, orders.cate, orders.dist from shop inner join orders on shop.sid=orders.sid where orders.uid=$uid");
			$stmt->execute();
			$_SESSION['myorderresult'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			header("Location: nav.php#myorder");
			exit();
		}
		else{
		$search = $_POST['smystatus'];
        $stmt = $conn->prepare("select shop.name, orders.oid, orders.status, orders.start, orders.end, orders.money, orders.sid, orders.cate, orders.dist from shop inner join orders on shop.sid=orders.sid where orders.uid=$uid and orders.status=:status");
        $stmt->execute(array('status'=>$search));
        $_SESSION['myorderresult'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		header("Location: nav.php#myorder");
		exit();
		}
    }
	else{
		$searchErr = "Please enter information";
		echo $searchErr;
		echo "<meta http-equiv='Refresh' content='1;URL=nav.php#myorder'>";
	}

?>
