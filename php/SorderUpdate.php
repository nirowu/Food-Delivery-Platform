<?php
    session_start();
    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat"); 
    $nav_url = 'http://localhost/hw2/nav.php';
    $dbservername='localhost';
    $dbname='db_ubereat';
    $dbusername='db_ubereat';
    $dbpassword='dba833217';
    $connection = new PDO("mysql:host=$dbservername; dbname=$dbname", $dbusername, $dbpassword);


    /* -------------------------------------------------------------------------- */
    /*                          action - done and finish                          */
    /* -------------------------------------------------------------------------- */
    $check = false;
    $OrderPrice = $_SESSION['OrderPrice'];
    if(isset($_POST['SorderCan']) ){

        $order_id =$_POST['SorderCan'];
        /* ---------------------- check if status == Not finish --------------------- */
        $stmt = $connection->prepare( "select status from orders where oid=:oid" );
        $stmt->execute(array('oid' => $order_id));
        $row = $stmt->fetch();
        $latest_status=$row['status'];
        if($row['status']!="Not Finish"){
          echo' <script type="text/JavaScript"> alert("The order status has been changed.");</script> ';
          echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";
          exit();
        }
        // echo $order_id;
        $sql = "UPDATE orders SET status='Cancel' WHERE OID= $order_id";
        if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . $conn->error;
        }
        /* ----------------------- // add transaction record : ---------------------- */
        $payAct = "Payment";
        $payTrader = $_SESSION['SorderShopName'];
        $PayTrans = "INSERT INTO transaction (money, act, trader) VALUES ('$OrderPrice','$payAct', '$payTrader')";
        $recAct = "Receive";
        $recTrader = $_SESSION['account'];
        $RecTrans = "INSERT INTO transaction (money, act, trader) VALUES ('$OrderPrice','$recAct', '$recTrader')";
        $conn->query($PayTrans);
        $conn->query($RecTrans);
        $stmt = $connection->prepare( "UPDATE product inner join detail on product.pid=detail.pid SET product.quantity=product.quantity+detail.amount WHERE detail.oid=$order_id" );
        $stmt->execute();
        $check = true;
    }
    else if(isset($_POST['SorderFin'])){
        $order_id =$_POST['SorderFin'];
        /* ---------------------- check if status == Not finish --------------------- */
        $stmt = $connection->prepare( "select status from orders where oid=:oid" );
        $stmt->execute(array('oid' => $order_id));
        $row = $stmt->fetch();
        $latest_status=$row['status'];
        if($row['status']!="Not Finish"){
          echo' <script type="text/JavaScript"> alert("The order status has been changed.");</script> ';
          echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";
          exit();
        }
        $timestamp = date("Y-m-d H:i:s");
        // echo $timestamp;
        $sql = "UPDATE orders SET status='Finished' WHERE OID= $order_id";
        $timeSql= "UPDATE orders SET end = '$timestamp' WHERE OID= $order_id";
        $conn->query($sql);
        $conn->query($timeSql);
        /* ----------------------- // add transaction record : ---------------------- */
        // $payAct = "Payment";
        // $payTrader = $_SESSION['account'];
        // $PayTrans = "INSERT INTO transaction (money, act, trader) VALUES ('$OrderPrice','$payAct', '$payTrader')";
        // $recAct = "Receive";
        // $recTrader = $_SESSION['SorderShopName'];
        // $RecTrans = "INSERT INTO transaction (money, act, trader) VALUES ('$OrderPrice','$recAct', '$recTrader')";

        // $conn->query($PayTrans);
        // $conn->query($RecTrans);
        $check = true;
    }
    /* ------------------------- refresh the fetch data ------------------------- */
    if($check){
      $sql = "SELECT * FROM `orders`;";
      $stmt = $connection->prepare($sql);
      $stmt->execute();
      $_SESSION['SorderRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo "<meta http-equiv='Refresh' content='0;URL=$nav_url'>";
      exit();

   }
    if(isset($_POST['SorderDetail_btn'])){
        // echo "detail";
        $oid = $_POST['SorderDetail_btn'];
        $stmt = $connection->prepare("select product.pic, product.pic_type, product.name, detail.price, detail.amount from product inner join detail on product.PID=detail.PID where detail.OID=$oid");
        $stmt->execute();
        $_SESSION['SorderDetail'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
    }
    echo "<meta http-equiv='Refresh' content='5;URL=$nav_url'>";
    // exit();
    
?>
<h2>Order</h2>

<table class="table" style=" margin-top: 15px">
<hr>
<hr>
  <thead>
    <tr>
      <th scope="col">Picture</th>
      <th scope="col">Meal name</th>
      <th scope="col">Price</th>
      <th scope="col">Order Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(!isset($_SESSION['SorderDetail']) )
      {
        echo '<tr>No data found</tr>';
        exit();
      }
      else{
      $subtotal =0;
        foreach($_SESSION['SorderDetail'] as $key=>$value){
          $orderInfo = "SELECT cate, dist FROM orders\n". "WHERE OID='$oid';";
          $stmt = $connection->prepare($orderInfo);
          $stmt->execute();
          $orderinfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach($orderinfo as $key=>$col){
            $dist = $col['dist'];
            $cate = $col['cate'];
          }
          $subtotal += $value['amount'] * $value['price'];
          if($cate=="pickup"){
            $totalmoney=$subtotal;
            $deliveryfee = 0;
            }
            else {
            $totalmoney = $subtotal + 10 * $dist;
            $deliveryfee = 10 * $dist;
            }
                
          $img=$value['pic'];
          $img_type=$value['pic_type'];
          $logodata = $img;
          $base64 = 'data:'.$img_type.';base64,' .$logodata . ' ';
          echo"<tr>";
          echo"<td align='center'><img src=$base64 width='100' height='100' ></td>";
          echo"<td align='center'>{$value['name']}</td>";
          echo"<td align='center'>{$value['price']}</td>";
          echo"<td align='center'>{$value['amount']}</td>";
          echo"</tr>";
        }                  
        echo"</tbody>";
        echo"<tfoot>";
        // echo"<hr>";
        echo"<tr>";
        echo"<td align='right' colspan='4'><b>Subtotal $$subtotal</b></td>";
        echo"</tr>";
        echo"<tr>";
        echo"<td align='right' colspan='4'><b>Delivery fee $$deliveryfee</b></td>";
        echo"</tr>";
        echo"<tr>";
        echo"<td align='right' colspan='4'><b>Total  $$totalmoney</b></td>";
        echo"</tr>";
        echo"</tfoot>";
      }
      
    ?>
  
</table>

      