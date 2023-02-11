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
$searchErr = '';
$employee_details='';
if(isset($_POST['Search']))
{
    if(!empty($_POST['sshop']))
    {
		$search = $_POST['sshop'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop where LOWER(shop.name) like LOWER('%$search%')");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();    
    }
	else if($_POST['sdist']!="all"){
		if($_POST['sdist']=="near"){
		$search = $_POST['sdist'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)'))<=6");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();
		}
		if($_POST['sdist']=="medium"){	
		$search = $_POST['sdist'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)'))>=3000000 and ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)'))<=4000000");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();
		}
		else if($_POST['sdist']=="far"){
		$search = $_POST['sdist'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)'))>=10000");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();
		}
	}
	else if(!empty($_POST['spricelow']) or !empty($_POST['spricehigh'])){
		if(!empty($_POST['spricelow']) and empty($_POST['spricehigh'])){
			$search = $_POST['spricelow'];
			$long=$_SESSION['longitude'];
			$lat=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop inner join product on shop.sid=product.sid where product.price>=$search");
			$stmt->execute();
			$_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			// $_SESSION['result']=array_unique($_SESSION['result']);
			header("Location: nav.php");
			exit();
		}
		else if(empty($_POST['spricelow']) and !empty($_POST['spricehigh'])){
			$search = $_POST['spricehigh'];
			$long=$_SESSION['longitude'];
			$lat=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop inner join product on shop.sid=product.sid where product.price<=$search");
			$stmt->execute();
			$_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			// $_SESSION['result']=array_unique($_SESSION['result']);
			header("Location: nav.php");
			exit();
		}
		else{
			$search = $_POST['spricelow'];
			$search2 = $_POST['spricehigh'];
			$long=$_SESSION['longitude'];
			$lat=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop inner join product on shop.sid=product.sid where product.price>=$search and product.price<=$search2");
			$stmt->execute();
			$_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			// $_SESSION['result']=array_unique($_SESSION['result']);
			header("Location: nav.php");
			exit();
		}
	}
	else if(!empty($_POST['smeal'])){
		$search = $_POST['smeal'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop inner join product on shop.sid=product.sid where LOWER(product.name) like LOWER('%$search%')");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();
	}
	else if(!empty($_POST['scategory'])){
		$search = $_POST['scategory'];
		$long=$_SESSION['longitude'];
		$lat=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.sid, shop.name, shop.cate, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($long $lat)')) as distance from shop where LOWER(shop.cate) like LOWER('%$search%')");
        $stmt->execute();
        $_SESSION['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $_SESSION['result']=array_unique($_SESSION['result']);
		header("Location: nav.php");
		exit();
	}
	else{
		$searchErr = "Please enter information";
		echo $searchErr;
		echo "<meta http-equiv='Refresh' content='1;URL=nav.php'>";
	}
}
else
{
	$searchErr = "Please enter information";
	echo $searchErr;
	echo "<meta http-equiv='Refresh' content='1;URL=nav.php'>";
}
?>