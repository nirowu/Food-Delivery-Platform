
      <li><a href="#MyOrder">Myorder</a><li>
      <li><a href="#ShopOrder">Shop Order</a><li>
      <li><a href="#Transation">Transation Record</a><li>
      <li><a href="logout.php">Logout</a><li>


      <div class="row">
          <div class="col-xs-10">
            <!-- <h5><b>Action:</b></h5>  -->
            </br>
            <label class="control-label col-sm-1" for="distance">distance</label>
              <div class="col-sm-5">   
            <select class="form-control" name="sdist">
                  <option value="All">All</option>
                  <option value="Payment">Payment</option>
                  <option value="Receive">Receive </option>
                  <option value="Recharge">Recharge</option>
            </select>
                  </div>
                  </br>
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Record ID</th>
                  <th scope="col">Action</th>
                  <th scope="col">Time</th>
                  <th scope="col">Trader<th>
                  <th scope="col">Amount change</th>
                </tr>
              </thead>
      </div>       
      

      <!-- shop Order page -->
      <div id="shoporder" class="tab-pane fade">
        <div class=" row  col-xs-8">
          <form class="form-horizontal" action="php/SelSorder.php">
            <div class="form-group">
              </br>
              <label class="control-label col-sm-1" for="distance">Action</label>
              <div class="col-sm-5">
                <select class="form-control" id="sel1">
                  <option value="sorder_all">All</option>
                  <option value="Payment">Finished</option>
                  <option value="Receive">Not Finish </option>
                  <option value="Recharge">Cancel</option>
                </select>
              </div>
              <table class="table" style=" margin-top: 70px;">
                <thead>
                  <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Shop name</th>
                    <th scope="col">Total Price<th>
                    <th scope="col">Order Details</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
            </div>
        </div>
      </div>             


      $_POST['TransSel']=="Payment"){
        echo"pay";
        $sql = "SELECT * FROM transaction WHERE act=?;";
        $stmt = $conn->prepare($sql);

    }
    else if($_POST['TransSel']=="Receive"){
        echo"receive";
        // $sql = "SELECT * FROM transaction WHERE act := \'Receiv\';";
    }
    else if($_POST['TransSel']=="Recharge"){
        echo"recharge";
        // $sql = "SELECT * FROM transaction WHERE act := \'Recharge\';";
    }
    
    // $result = $conn->query($sql);
    // $result = $result->fetch_all();
    // echo $result; 
    // $_SESSION['TransRes']=$result;
    // $_SESSION['sel']=$sql;
    
    $stmt->execute();
    $_SESSION['TransRes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // header("Location: nav.php");
    // exit();


    <?php     
                    if(isset($_SESSION['SorderDetail'])){
                    $SorderDetail = $_SESSION['SorderDetail'];
                    foreach($SorderDetail as $row){
                      echo"<tr>";
                      echo"<th>hello</th>";
                      $SorderPID = $row['PID'];
                      // find the detail from where details got same oid
                      $DetailSql = "SELECT * FROM product WHERE PID=?;";
                      $stmt = $conn->prepare($DetailSql);
                      $stmt->execute([$SorderDetail]);
                      $Detail_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      foreach($Detail_info as $val){
                        $img=$val['pic'];
                        $img_type=$val['pic_type'];
                        $base64 = 'data:'.$img_type.';base64,' .$img . ' ';
                        echo "<th><img src =$base64 width='100' height='100'></th>";
                        echo "<th>{$val['name']}</th>";
                        echo "<th>{$val['price']}</th>";
                      }
                      echo "<th>{$row['amount']}</th>";
                      echo "</tr>";
                      }
                  
                    }
                  ?>


<?php          
                      if(isset($_POST['SorderDetail_btn'])){
                        // echo "hello world";
                        echo "<tr>";
                        echo "<th>{$_SESSION['OID']}</th>";
                        echo "</tr>";
                        // $order_id = $_SESSION['OID'];
                        // $OrderSql = "SELECT * FROM detail WHERE OID=?;";
                        // $stmt = $conn->prepare($OrderSql);
                        // $stmt->execute([$order_id]);
                        // $_SESSION['SorderDetail'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                        // $SorderDetail = $_SESSION['SorderDetail'];
                        // foreach($SorderDetail as $row){
                        //   echo"<tr>";
                        //   $SorderPID = $row['PID'];
                        //   // find the detail from where details got same oid
                        //   $DetailSql = "SELECT * FROM product WHERE PID=?;";
                        //   $stmt = $conn->prepare($DetailSql);
                        //   $stmt->execute([$SorderDetail]);
                        //   $Detail_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        //   foreach($Detail_info as $val)
                        //   {
                        //     $img=$val['pic'];
                        //     $img_type=$val['pic_type'];
                        //     $base64 = 'data:'.$img_type.';base64,' .$img . ' ';
                        //     echo "<th><img src =$base64 width='100' height='100'></th>";
                        //     echo "<th>{$val['name']}</th>";
                        //     echo "<th>{$val['price']}</th>";
                        //   }
                        //   echo "<th>{$row['amount']}</th>";
                        //   echo "</tr>";
                        //   }
                      }
                    
             
                    ?>



<div class="modal fade" id="SorderDetail" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="staticBackdropLabel">Order</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12">
                  <table class="table" style=" margin-top: 15px;">
                    <thead>
                      <tr>
                        <th scope="col">Picture</th>
                        <th scope="col">Meal name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Order Quantity</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div style="text-align:right;">
                <h5>Subtotal </h5>
              </div>
              <div style="text-align:right;">
                <h5>Delivery fee </h5>
              </div>
              <div style="text-align:right;">
                <h5>Total </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- </form> -->
      <!-- modal end-->


      data-toggle='modal' data-target='#SorderDetail'











      <div class="modal fade" id="SorderDetail" data-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="staticBackdropLabel">Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <table class="table" style=" margin-top: 15px;">
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

                      $img=$value['pic'];
                      $img_type=$value['pic_type'];
                      $logodata = $img;
                      $base64 = 'data:'.$img_type.';base64,' .$logodata . ' ';
                      echo"<tr>";
                      echo"<td><img src=$base64 width='100' height='100' ></td>";
                      echo"<td>{$value['name']}</td>";
                      echo"<td>{$value['price']}</td>";
                      echo"<td>{$value['amount']}</td>";
                      echo"</tr>";
                      $subtotal += $value['amount']*$value['price'];
                      if($cate=="pickup"){
                        $totalmoney=$subtotal;
                        $deliveryfee=0;
                        }
                        else {
                        $totalmoney=$subtotal+10*$dist;
                        $deliveryfee=10*$dist;
                        }
                    }
                 }
                ?>                  
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div style="text-align:right;">
          <h5>Subtotal=<?php echo $subtotal;?> </h5>
        </div>
        <div style="text-align:right;">
          <h5>Delivery fee=<?php echo $deliveryfee;?> </h5>
        </div>
        <div style="text-align:right;">
          <h5>Total=<?php echo $totalmoney;?> </h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </form> -->
<!-- modal end-->


      <!-- my order page -->
      <div id="myorder" class="tab-pane fade">
        </br>
        <div class=" row  col-xs-8">
          <form class="form-horizontal" action="myordersrch.php" method="post">
            <div class="form-group">
              <label class="control-label col-sm-1" for="status">Status</label>
                <div class="col-sm-5">
                  <select class="form-control" name="smystatus">
                    <option value="all">All</option>
                    <option value="Finished">Finished</option>
                    <option value="Not Finished">Not Finished</option>
                    <option value="Cancel">Cancel</option>
                  </select>
                </div>
                <button type="submit" name="Search" value="Search" style="margin-left: 18px;"
                  class="btn btn-primary">Search
                </button>
            </div>
          </form>
        </div>
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Status</th>
                  <th scope="col">Start</th>
                  <th scope="col">End</th>
                  <th scope="col">Shop name</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Order Details</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 if(!isset($_SESSION['myorderresult']) )
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($_SESSION['myorderresult'] as $key=>$value)
                    {
                      echo"<tr>";
                      echo"<th>{$value['oid']}</th>";
                      echo"<th>{$value['status']}</th>";
                      echo"<th>{$value['start']}</th>";
                      echo"<th>{$value['name']}</th>";
                      echo"<th>{$value['money']}</th>";
                      echo"</tr>";
                        ?>
                  <th>
                    <form action="myorderdetail.php" class="fh5co-form animate-box" data-animate-effect="fadeIn"
                      method="post">
                      <input type="hidden" name="oid" value="<?php echo $value['oid'];?>">
                      <input type="hidden" name="dist" value="<?php echo $value['dist'];?>">
                      <input type="hidden" name="cate" value="<?php echo $value['cate'];?>">
                      <input type="submit" class="btn btn-info" value="order details">
                    </form>
                  </th>
                  <?php if($value['status']=="Not Finished"): ?>
                  <th>
                    <form action="myordercancel.php" class="fh5co-form animate-box" data-animate-effect="fadeIn"
                      method="post">
                      <input type="hidden" name="oid" value="<?php echo $value['oid'];?>">
                      <input type="hidden" name="sid" value="<?php echo $value['sid'];?>">
                      <input type="hidden" name="money" value="<?php echo $value['money'];?>">
                      <input type="submit" class="btn btn-danger" value="Cancel">
                    </form>
                  </th>
                  <?php endif; ?>
                </tr>
                <?php }
			}?>
              </tbody>
            </table>

          </div>
        </div>
    </div>


    // echo $_SESSION['AccessRight'];
    // if(isset($_POST['SorderCan'])||isset($_POST['SorderFin'])){
    //   if(isset($_SESSION['AccessRight']) ){
    //     if($_SESSION['AccessRight'] == 0){
    //       echo"You don't have access right.";
    //       echo "<script>
    //       alert('You don't have access right.')
    //       </script>";
    //       echo "<meta http-equiv='Refresh' content='5;URL=$nav_url'>";
    //       exit();
    //     }      
    //   }
    // }