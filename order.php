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
 <!-- Modal -->
            <div class="modal fade" id="showmenu" data-backdrop="static" tabindex="-1" role="dialog"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
				  <a href="nav.php">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
				  </a>
                    <h4 class="modal-title">Order</h4>
                  </div>
                  <div class="modal-body">
                    <!--  -->

                    <div class="row">
                      <div class="  col-xs-12">
                        <table class="table" style=" margin-top: 15px;">
                          <thead>
                            <tr>
                              <th scope="col">Picture</th>

                              <th scope="col">meal name</th>

                              <th scope="col">price</th>

                              <th scope="col">Order Quantity</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
							$subtotal=0;
							$flag=0;
							$disableflag=0;
							$sentence="Following product quantity is not enough: ";
                            $menusid=$_SESSION['menusid'];
                            $stmt = $conn->prepare("select * from product where sid=:sid");
                            $stmt->execute(array('sid' => $menusid));
                            $menu_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							
							
							
							?>
							<form action="orderact.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
                            <?php foreach($menu_result as $k=>$val){
                              $img=$val['pic'];
                              $img_type=$val['pic_type'];
                              $logodata = $img;
                              $base64 = 'data:'.$img_type.';base64,' .$logodata . ' ';
							  if($_POST['orders'][$k]==0){
								  $k=$k+1;
								  continue;
							  }
                              if($val['exist']==0){
								  $disableflag=1;
								 echo' <script type="text/JavaScript"> alert("Product not exist"); 
								  </script> ';
							  }
							  if($val['quantity']<$_POST['orders'][$k]){
								  $disableflag=1;
								  $flag=1;
								  $sentence.=$val['name'];
								  $sentence.=" ";
							  }
                            ?>
                            <tr>
                              
                              <td><img src=<?php echo $base64;?> width="100" height="100" ?></td>
                              <td>
                                <?php echo $val['name'];?>
                              </td>
                              <td>
                                <?php echo $val['price'];?>
                              </td>
                              <td>
								<?php echo $_POST['orders'][$k];?>
								  <input type="hidden" name="detailpid[]" value="<?php echo $val['PID'];?>" >
								  <input type="hidden" name="detailprice[]" value="<?php echo $val['price'];?>" >
								  <input type="hidden" name="orders[]" value="<?php echo $_POST['orders'][$k];?>" >
							 </td>
							<?php $subtotal+=$_POST['orders'][$k]*$val['price'];?>
                            </tr>
                            <?php
				  }
				?>
                          </tbody>
                        </table>
                      </div>
                    </div>
					 <!--  -->
                  </div>
				  <label class="control-label col-sm-1" >Subtotal:</label><?php echo $subtotal;?>
				  <?php if($_POST['ordertype']=="pickup"){
					  $totalmoney=$subtotal;
					  $deliveryfee=0;
					  }
					  else{
					  $totalmoney=$subtotal+10*$_SESSION['orderdist'];
					  $deliveryfee=10*$_SESSION['orderdist'];
					  }
					  if($totalmoney>$_SESSION[ 'wallet' ]){
						  $disableflag=1;
						  echo' <script type="text/JavaScript"> 
						  alert("Not enough money");
						 </script> ';
								  
					  }
					  
					  if($flag==1){
						  echo "<script type='text/javascript'>alert('$sentence');</script>";
					  }
				  ?>
				  <input type="hidden" name="ordertype" value="<?php echo $_POST['ordertype'];?>" >
				  <input type="hidden" name="totalmoney" value="<?php echo $totalmoney;?>" >
				  <label class="control-label col-sm-1" >Delivery fee:</label><?php echo $deliveryfee;?>
				  <label class="control-label col-sm-1" >Total Price:</label><?php echo $totalmoney;?>
                  <div class="modal-footer">
					<input type="submit" id="toorderact" class="btn btn-default" <?php if ($disableflag==1){ ?> disabled <?php } ?>value="Order">
				  </div>
				  </form>
                </div>
              </div>
            </div>
