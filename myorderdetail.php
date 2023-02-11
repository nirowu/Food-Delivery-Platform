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
$oid=$_POST['oid'];
$dist=$_POST['dist'];
$cate=$_POST['cate'];
$subtotal=0;
$stmt = $conn->prepare("select product.pic, product.pic_type, product.name, detail.price, detail.amount from product inner join detail on product.pid=detail.pid where detail.oid=$oid");
$stmt->execute();
$_SESSION['myorderdetail'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
	                <!-- Modal -->
  <div class="modal fade" id="myorderdetails"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
	
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<a href="nav.php#myorder">
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
                 if(!isset($_SESSION['myorderdetail']) )
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($_SESSION['myorderdetail'] as $key=>$value){
                  $img=$value['pic'];
                  $img_type=$value['pic_type'];
                  $logodata = $img;
                  $base64 = 'data:'.$img_type.';base64,' .$logodata . ' ';
                  if($value['amount']==0){
                        $k=$k+1;
								  continue;
						      }
					        ?>
                <tr>
                   <td><img src=<?php echo $base64;?> width="100" height="100" ?></td>
                  <td>
                    <?php echo $value['name'];?>
                  </td>
                  <td>
                    <?php echo $value['price'];?>
                  </td>
                  <td>
                    <?php echo $value['amount'];?>
                  </td>
				  <?php $subtotal+=$value['amount']*$value['price'];?>
                </tr>
              
			<?php }
			}?>
	  <label class="control-label col-sm-1" >Subtotal:</label><?php echo $subtotal;?>
	  <?php if($cate=="pickup"){
		  $totalmoney=$subtotal;
		  $deliveryfee=0;
		  }
		  else{
		  $totalmoney=$subtotal+10*$dist;
		  $deliveryfee=10*$dist;
		  }
	  ?>
<label class="control-label col-sm-1" >Delivery fee:</label><?php echo $deliveryfee;?>
	   
<label class="control-label col-sm-1" >Total Price:</label><?php echo $totalmoney;?>
	  

			</tbody>
            </table>
          </div>

        </div>
         <!--  -->
        </div>
      </div>
      
    </div>
  </div>