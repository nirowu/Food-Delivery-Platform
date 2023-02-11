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

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Hello, world!</title>
</head>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand " href="#">WebSiteName</a>
      </div>
    </div>
  </nav>
  <div class="container">

    <ul class="nav nav-tabs">
      <li class="active"><a href="#home">Home</a></li>
      <li><a href="#menu1">shop</a></li>
      <li><a href="#myorder">Myorder</a></li>
      <li><a href="#shoporder">Shop Order</a></li>
      <li><a href="#transaction">Transation Record</a></li>
      <li><a href="logout.php">Logout</a></li>

    </ul>
    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <h3>Profile</h3>
        <div class="row">
          <div class="col-xs-12">
            Account:
            <?php echo $_SESSION['account']?>,
            <?php echo $_SESSION['username']?>,
            <?php echo $_SESSION['identifier']?>, PhoneNumber:
            <?php echo $_SESSION['phone_number']?>, location:
            <?php echo $_SESSION['latitude']?>,
            <?php echo $_SESSION['longitude']?>

            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
              data-target="#location">edit location</button>
            <!--  -->
            <div class="modal fade" id="location" data-backdrop="static" tabindex="-1" role="dialog"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">edit location</h4>
                  </div>
                  <div class="modal-body">
                    <label class="control-label " for="latitude">latitude</label>
                    <form action="homeact.php" class="fh5co-form animate-box" data-animate-effect="fadeIn"
                      method="post">
                      <input class="form-control" type="number" name="latitude" value="0" min="-90" max="90" placeholder="enter latitude">
                      <br>
                      <label class="control-label " for="longitude">longitude</label>
                      <input class="form-control" type="number" name="longitude" value="0" min="-180" max="180" placeholder="enter longitude">
                  </div>
                  <div class="modal-footer">
                    <input type="submit" value="Edit" class="btn btn-default">
                  </div>
                  </form>
                </div>
              </div>
            </div>



            <!--  -->
            walletbalance:
            <?php echo $_SESSION['wallet']?>
            <!-- Modal -->
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
              data-target="#myModal">Add value</button>
            <div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" role="dialog"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add value</h4>
                  </div>
                  <div class="modal-body">
                    <form action="wallet.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
                    <input class="input-group-field" type="number" name="addmoney" value="0" min="0" step="1" placeholder="enter add value">
                  </div>
                  <div class="modal-footer">
                    <input type="submit" value="Add" class="btn btn-default">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- 
                
             -->
        <h3>Search</h3>
        <div class=" row  col-xs-8">
          <form class="form-horizontal" action="homeact2.php" method="post">
            <div class="form-group">
              <label class="control-label col-sm-1" for="Shop">Shop</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="sshop" placeholder="Enter Shop name">
              </div>
              <label class="control-label col-sm-1" for="distance">distance</label>
              <div class="col-sm-5">


                <select class="form-control" name="sdist">
                  <option value="all">-</option>
                  <option value="near">near</option>
                  <option value="medium">medium </option>
                  <option value="far">far</option>

                </select>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-sm-1" for="Price">Price</label>
              <div class="col-sm-2">

                <input type="text" class="form-control" name="spricelow">

              </div>
              <label class="control-label col-sm-1" for="~">~</label>
              <div class="col-sm-2">

                <input type="text" class="form-control" name="spricehigh">

              </div>
              <label class="control-label col-sm-1" for="Meal">Meal</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="smeal" placeholder="Enter Meal">

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-1" for="category"> category</label>


              <div class="col-sm-5">
                <input type="text" class="form-control" name="scategory" placeholder="Enter shop category">

              </div>
              <button type="submit" name="Search" value="Search" style="margin-left: 18px;"
                class="btn btn-primary">Search</button>

            </div>
          </form>
        </div>
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">shop name</th>
                  <th scope="col">shop category</th>
                  <th scope="col">Distance(km)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 if(!isset($_SESSION['result']) )
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($_SESSION['result'] as $key=>$value)
                    {
                        ?>
                <tr>
                  <td>
                    <?php echo $key+1;?>
                  </td>
                  <td>
                    <?php echo $value['name'];?>
                  </td>
                  <td>
                    <?php echo $value['cate'];?>
                  </td>
                  <td>
                    <?php echo $value['distance']/1000;?>
                  </td>
                  <td>
                    <form action="menu.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post"
                      id="<?php echo $key+1;?>">
                      <input type="hidden" name="menusid" value="<?php echo $value['sid'];?>">
                      <input type="hidden" name="orderdist" value="<?php echo $value['distance']/1000;?>">
                    </form>
                    <button type="submit" form="<?php echo $key+1;?>" name="openmenubutton" class="btn btn-info">Open
                      menu</button>
                  </td>
                </tr>
                <?php }
			}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <!-- end of search -->
      <div id="menu1" class="tab-pane fade">
        <!-- here -->
        <h3> Start a business </h3>
        <div class="form-group ">
          <form action="php/shop.php" method="post">
            <div class="row">
              <div class="col-xs-2">
                <label for="ex5">shop name</label>
                <input class="form-control" id="shop_id" placeholder="macdonald" type="text" name="shop_name"
                  required="required">
              </div>
              <div class="col-xs-2">
                <label for="ex5">shop category</label>
                <input class="form-control" id="category_id" placeholder="fast food" type="text" name="category"
                  required="required">
              </div>
              <div class="col-xs-2">
                <label for="ex6">longitude</label>
                <input class="form-control" id="longitude_id" placeholder="121.00028167648875" type="number"
                  name="slongitude" required="required" step="0.00000000000001" max="180" min="-180">
              </div>
              <div class="col-xs-2">
                <label for="ex8">latitude</label>
                <input class="form-control" id="latitude_id" placeholder="24.78472733371133" type="number"
                  name="slatitude" required="required" step="0.00000000000001" max="90" min="-90">
              </div>
            </div>
        </div>
        <div class=" row" style=" margin-top: 25px;">
          <div class=" col-xs-3">
            <button type="submit" class="btn btn-primary" id="shop_register">register</button>
          </div>
        </div>
        </form>

        <script>
            <?php
              if (isset($_SESSION['validate'])) {
                echo "var check=".$_SESSION['validate'].";";
          }
          else {
                  echo "var check=0;";
          }
            ?>
            if (check) {
            shop_id.setAttribute("placeholder", "<?php echo $_SESSION['shop_name'];?>");
            category_id.setAttribute("placeholder", "<?php echo $_SESSION['category'];?>");
            longitude_id.setAttribute("placeholder", "<?php echo $_SESSION['slongitude'];?>");
            latitude_id.setAttribute("placeholder", "<?php echo $_SESSION['slatitude'];?>");
            shop_id.setAttribute("readonly", "readonly");
            category_id.setAttribute("readonly", "readonly");
            longitude_id.setAttribute("readonly", "readonly");
            latitude_id.setAttribute("readonly", "readonly");
            shop_register.setAttribute("disabled", " ");
          }
        </script>

        <!-- here -->
        <hr>
        <h3>ADD</h3>

        <div class="form-group ">
          <div class="row">
            <!-- here -->
            <form action="php/add.php" method="post" Enctype="multipart/form-data">
              <div class="col-xs-6">
                <label for="ex3">meal name</label>
                <input class="form-control" id="ex3" type="text" name="meal_name" required="required">
              </div>
          </div>
          <div class="row" style=" margin-top: 15px;">
            <div class="col-xs-3">
              <label for="ex7">price</label>
              <input class="form-control" id="ex7" type="number" name="price" required="required" min=0>
            </div>
            <div class="col-xs-3">
              <label for="ex4">quantity</label>
              <input class="form-control" id="ex4" type="number" name="quantity" required="required" min=0>
            </div>
          </div>

          <div class="row" style=" margin-top: 25px;">

            <div class=" col-xs-3">
              <label for="ex12">上傳圖片</label>
              <input id="myFile" type="file" name="myFile" multiple class="file-loading" required="required">

            </div>
            <div class=" col-xs-3">
              <button style=" margin-top: 15px;" type="submit" value="upload" class="btn btn-primary">Add</button>
            </div>
          </div>
        </div>
        </form>
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                  <th scope="col">meal name</th>
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  
                  if(isset($_SESSION['SID'])){
                    $temp = $_SESSION['SID'];
                    echo "$temp";
                  }
                  else{
                    $temp=0;
                  }
                  $connection = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat"); 
                  $sql_product="SELECT * FROM product\n". "WHERE SID='$temp' and exist=1;";
                  // $sql = "SELECT * FROM product;"; 
                  $result = $connection->query($sql_product);
                  if($result->num_rows > 0){
                    $count =0;
                    while($row = $result->fetch_assoc()) { 
                      $count = $count+1;
                      $meal_name = $row["name"];
                      // echo $meal_name;
                      $_SESSION['name']= $meal_name;
                      $base64 = 'data:'.$row["pic_type"].';base64,' . $row["pic"] . ' ';
                  ?>
                <tr>
                  <th>
                    <?php echo $count;?>
                  </th>
                  <td><img src=<?php echo $base64;?> width="100" height="100" alt=
                    <?php echo $row['name']; ?>>
                  </td>
                  <td>
                    <?php echo $row['name']; ?>
                  </td>
                  <td>
                    <?php echo $row['price']; ?>
                  </td>
                  <td>
                    <?php echo $row['quantity']; ?>
                  </td>
                  <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#coffee-1">
                      Edit
                    </button></td>
                  <!-- Modal -->
                  <form method="post" action="php/edit.php">
                    <div class="modal fade" id="coffee-1" data-backdrop="static" tabindex="-1" role="dialog"
                      aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">
                              <?php echo $meal_name; ?> Edit
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-xs-6">
                                <label for="ex72">price</label>
                                <input class="form-control" id="ex72" type="number" name="new_price" required="required"
                                  min=0>
                              </div>
                              <div class="col-xs-6">
                                <label for="ex42">quantity</label>
                                <input class="form-control" id="ex42" type="number" name="new_quantity"
                                  required="required" min=0>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" name="update" value=<?php echo
                              $row['PID'];?>>Edit</button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </form>
                  <form action="php/delete.php" method="post">
                    <td><button type="submit" class="btn btn-danger" name="delete" value=<?php echo
                        $row['PID'];?>>Delete</button></td>
                  </form>
                </tr>
                <?php 
                    }

                    }
                  ?>

              </tbody>
            </table>
          </div>

        </div>


      </div>

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
                  <option value="Not Finished">Not Finish</option>
                  <option value="Cancel">Cancel</option>

                </select>
              </div>
              <button type="submit" name="Search" value="Search" style="margin-left: 18px;"
                class="btn btn-primary">Search</button>
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
                        ?>
                <tr>
                  <td>
                    <?php echo $value['oid'];?>
                  </td>
                  <td>
                    <?php echo $value['status'];?>
                  </td>
                  <td>
                    <?php echo $value['start'];?>
                  </td>
                  <td>
                    <?php echo $value['end'];?>
                  </td>
				   <td>
                    <?php echo $value['name'];?>
                  </td>
				   <td>
                    <?php echo $value['money'];?>
                  </td>
                    <td>
					<form action="myorderdetail.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
					<input type="hidden" name="oid" value="<?php echo $value['oid'];?>" >
					<input type="hidden" name="dist" value="<?php echo $value['dist'];?>" >
					<input type="hidden" name="cate" value="<?php echo $value['cate'];?>" >
					<input type="submit" class="btn btn-info" value="order details">
					</form>
				 </td>
				 <?php if($value['status']=="Not Finish"): ?>
				   <td>
					<form action="myordercancel.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
					<input type="hidden" name="oid" value="<?php echo $value['oid'];?>" >
					<input type="hidden" name="sid" value="<?php echo $value['sid'];?>" >
					<input type="hidden" name="money" value="<?php echo $value['money'];?>" >
					<input type="submit" class="btn btn-danger" value="Cancel">
					</form>
				 </td>
				<?php endif; ?>
                </tr>
			<?php }
			}?>
		 </tbody>
	</table>

  </div>
</div>
    </div>
        <!-- my order page -->

        <!-- shoporder page -->
        <div id="shoporder" class="tab-pane fade">
          <form class="form-horizontal" action="php/SelSorder.php" method="post">
            </br>
            <label class="control-label col-sm-1">Status</label>
            <div class="col-sm-5">
              <select class="form-control" name="SorderSel">
                <option value="SorderAll">All</option>
                <option value="Finished">Finished</option>
                <option value="Not Finish">Not Finish </option>
                <option value="Cancel">Cancel</option>
              </select>
            </div>
            <button type="submit" name="SorderSearch" style="margin-left: 18px;" class="btn btn-primary">Search</button>
          </form>
          <table class="table" style=" margin-top: 40px;">
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
            <form action="php/SorderUpdate.php" method="post">
              <?php
                      $_SESSION['SafetyCheck']=0;
                      $count=0;
                      $AccessRight =True;
                      if(isset($_SESSION['SorderRes']) ){
                        $SorderRes = $_SESSION['SorderRes'];
                        foreach($SorderRes as $row){
                          $count = $count +1;
                          $SID = $row['SID'];
                          $_SESSION['OID'] = $row['OID'];
                          $_SESSION['OrderPrice'] = $row['money'];
                          $shopsql= "SELECT name FROM shop\n". "WHERE SID='$SID' ;"; 
                          $res = $connection->query($shopsql);
                          $SorderShop = $res->fetch_assoc();
                          $_SESSION['SorderShopName'] = $SorderShop['name'];
                          $status = $row['status'];

                          // access
                          // echo"{$_SESSION['UID']}";
                          $AccessSql = "SELECT orders.UID  from orders inner JOIN shop on orders.SID = shop.SID WHERE orders.UID ={$_SESSION['UID']} and orders.OID={$row['OID']};";
                          $Access = $connection->query($AccessSql);
                          $AccessRight = 1;
                          if($Access->num_rows > 0){
                            $AccessRight = 1;
                          }
                          else{
                            $AccessRight = 0;
                          }       
                          echo $AccessRight;
                          echo "<tbody>";
                          echo  "<tr>";
                          echo "<th>$count</th>";
                          echo "<th>{$row['status']}</th>";
                          echo "<th>{$row['start']}</th>";
                          echo "<th>{$row['end']}</th>";
                          echo "<th>{$SorderShop['name']}</th>";
                          echo "<th>{$row['money']}</th>";
                          echo "<th><button type='submit' class='btn btn-info' name='SorderDetail_btn' value='{$row['OID']}' data-toggle='modal' data-target='#SorderDetail' >Order details</button></th>";                         
                          
                          if($AccessRight){
                            // if($status == "Finished" ){               
                            //   echo "<th><button type='submit' class='btn btn-danger' name='SorderCan' value='{$row['OID']}'>Cancel</button></th>";
                            // }
                            if($status == "Not Finish"){
                              echo "<th>
                              <button type='submit' class='btn btn-success' name='SorderFin' value='{$row['OID']}'>Done</button>
                              <button type='submit' class='btn btn-danger' name='SorderCan' value='{$row['OID']}'>Cancel</button>
                              </th>";
                            }   
                          }
                          else{
                            // if($status == "Finished" ){    
                            //   echo "<th><button type='button' class='btn btn-danger's value='{$row['OID']}' onclick='error()'>Cancel</button></th>";
                            // }
                            if($status == "Not Finish" ){
                              echo "<th>";
                              echo"
                              <button type='button' class='btn btn-success' value='{$row['OID']}' onclick='error()'>Done</button>
                              <button type='button' class='btn btn-danger' value='{$row['OID']}' onclick='error()'>Cancel</button>
                              </th>";
                              
                            }     
                          }                            
                          echo "</tr></tbody>";

                        }
                      }
                    ?>
                    
            </form>
          </table>
          </form>
        </div>
        <script>
          function error(){
          alert("You don't have right to access.");
          }
        </script>

        <!-- shoporder done -->



        <!-- transaction page -->
        <div id="transaction" class="tab-pane fade">
          <div class=" row  col-xs-8">
            <form class="form-horizontal" action="php/SelTran.php" method="post">
              </br>
              <label class="control-label col-sm-1">Action</label>
              <div class="col-sm-5">
                <select class="form-control" name="TransSel">
                  <option value="All">All</option>
                  <option value="Payment">Payment</option>
                  <option value="Receive">Receive </option>
                  <option value="Recharge">Recharge</option>
                </select>
              </div>
              <button type="submit" name="TransSearch" style="margin-left: 18px;"
                class="btn btn-primary">Search</button>
              <table class="table" style=" margin-top: 40px;">
                <thead>
                  <tr>
                    <th>Record ID</th>
                    <th scope="col">Action</th>
                    <th scope="col">Time</th>
                    <th scope="col">Trader
                    <th>
                    <th scope="col">Amount change</th>
                  </tr>
                </thead>
                <?php
                    $count = 0;
                    if(isset($_SESSION['TransRes'])){
                      $TransRes =$_SESSION['TransRes'];
                      foreach($TransRes as $row){
                        $count = $count + 1;
                        echo "<tbody>";
                        echo  "<tr>";
                        echo "<th>$count</th>";
                        echo "<th>{$row['act']}</th>";
                        echo "<th>{$row['time']}</th>";
                        echo "<th>{$row['trader']}</th>";
                        echo "<th>{$row['money']}</th>";
                        echo "</tr></tbody>";
                      }
                    }
                    ?>
              </table>
            </form>
          </div>
        </div>
        <!-- transaction done -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
        <script>
          $(document).ready(function () {
            $(".nav-tabs a").click(function () {
              $(this).tab('show');
            });
          });
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>