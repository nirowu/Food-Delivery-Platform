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
$lat = $_POST[ 'latitude' ];
$long = $_POST[ 'longitude' ];
if ( $lat <= 90 and $lat >= -90 ) {
    if ( $long <= 180 and $long >= -180 ) {
        $acc = $_SESSION[ 'account' ];
        $stmt = $conn->prepare( 'UPDATE user SET latitude=:latitude, longitude=:longitude WHERE account=:account' );
        $stmt->execute( array(
            'latitude' => $lat,
            'longitude' => $long,
            'account' => $acc
        ) );
        $_SESSION[ 'latitude' ] = $lat;
        $_SESSION[ 'longitude' ] = $long;
        header( 'Location: nav.php' );
        exit();
    } else {
        $searchErr = 'input out of range';
        echo $searchErr;
        header( 'Location: nav.php' );
        exit();
    }
}

?>

