<?php
session_start();
$_SESSION[ 'Authenticated' ] = false;
$dbservername = 'localhost';
$dbname = 'db_ubereat';
$dbusername = 'db_ubereat';
$dbpassword = 'dba833217';
try
 {
    if ( !isset( $_POST[ 'uname' ] ) || !isset( $_POST[ 'pwd' ] ) )
 {
        header( 'Location: index.html' );
        exit();
    }
    if ( empty( $_POST[ 'uname' ] ) || empty( $_POST[ 'pwd' ] ) )
    throw new Exception( 'Please input user name and 
password.' );
    $uname = $_POST[ 'uname' ];
    $pwd = $_POST[ 'pwd' ];
    $conn = new PDO( "mysql:host=$dbservername;dbname=$dbname",
    $dbusername, $dbpassword );
    # set the PDO error mode to exception
    $conn->setAttribute( PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION );
    $stmt = $conn->prepare( "select UID, account, password, name, identifier, 
        phone_number, longitude, latitude, wallet from user where account=:account" );
    $stmt->execute( array( 'account' => $uname ) );
    if ( $stmt->rowCount() == 1 )
 {
        $row = $stmt->fetch();
         if ( $row[ 'password' ] == hash( 'sha256', $_POST[ 'pwd' ] ) )
 {
            $_SESSION[ 'Authenticated' ] = true;
            $_SESSION[ 'UID' ] = $row[ 'UID' ];
            $_SESSION[ 'account' ] = $row[ 'account' ];
            $_SESSION[ 'username' ] = $row[ 'name' ];
            $_SESSION[ 'identifier' ] = $row[ 'identifier' ];
            $_SESSION[ 'phone_number' ] = $row[ 'phone_number' ];
            $_SESSION[ 'latitude' ] = $row[ 'latitude' ];
            $_SESSION[ 'longitude' ] = $row[ 'longitude' ];
            $_SESSION[ 'wallet' ] = $row[ 'wallet' ];
            header( 'Location: nav.php' );
            exit();
        } else
        throw new Exception( 'Wrong password.' );
    } else
    throw new Exception( 'Account not exists.' );
} catch( Exception $e )
 {
    $msg = $e->getMessage();
    session_unset();

    session_destroy();

    echo <<<EOT
    <!DOCTYPE html>
    <html>
    <body>
    <script>
    alert( "$msg" );
    window.location.replace( 'index.html' );
    </script>
    </body>
    </html>
    EOT;
}
?>
