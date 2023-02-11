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
                    <h4 class="modal-title">menu</h4>
                  </div>
                  <div class="modal-body">
                    <!--  -->

                    <div class="row">
                      <div class="  col-xs-12">
                        <table class="table" style=" margin-top: 15px;">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Picture</th>

                              <th scope="col">meal name</th>

                              <th scope="col">price</th>
                              <th scope="col">Quantity</th>

                              <th scope="col">Order</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $menusid=$_POST['menusid'];
							$_SESSION['menusid']=$menusid;
							$orderdist=$_POST['orderdist'];
							$_SESSION['orderdist']=$orderdist;
                            $stmt = $conn->prepare("select * from product where sid=:sid");
                            $stmt->execute(array('sid' => $menusid));
                            $menu_result = $stmt->fetchAll(PDO::FETCH_ASSOC);?>
							<form action="order.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
                            <?php foreach($menu_result as $k=>$val){
                              $img=$val['pic'];
                              $img_type=$val['pic_type'];
                              $logodata = $img;
                              $base64 = 'data:'.$img_type.';base64,' .$logodata . ' ';
							 if($val['exist']==0){
								  $k=$k+1;
								  continue;
							  }
                            ?>
                            <tr>
                              <td>
                                <?php echo $k+1;?>
                              </td>
                              <td><img src=<?php echo $base64;?> width="100" height="100" ?></td>
                              <td>
                                <?php echo $val['name'];?>
                              </td>
                              <td>
                                <?php echo $val['price'];?>
                              </td>
                              <td>
                                <?php echo $val['quantity'];?>
                              </td>
                              <td>
								<input class="input-group-field" type="number" name="orders[]" value="0" min="0" step="1">
							 </td>
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
				  
				  <label class="control-label col-sm-1" for="Type">Type</label>
                <select class="form-control" name="ordertype">
                  <option value="delivery">Delivery</option>
                  <option value="pickup">Pick-up</option>
                </select>
                  <div class="modal-footer">
					<input type="submit" value="Calculate the price" class="btn btn-default">
                  </div>
				  </form>
                </div>

              </div>
            </div>
