<?php

    $conn = mysqli_connect('localhost','db_ubereat','dba833217',"db_ubereat"); 
    $nav_url = 'http://localhost/hw2/nav.php';
    

    if(isset($_POST['update'])){
        $meal_id =$_POST['update'];
        // if the product on an not finished order then can't change it's money
        $status ="Not finish";
        $SatyCheck = "SELECT DISTINCT detail.PID FROM detail inner JOIN orders ON orders.OID = detail.OID WHERE orders.status ='$status';";
        if (($result = $conn->query($SatyCheck)) !== FALSE)
        {
            while($row = $result->fetch_array())
            {
                if ($meal_id == $row[0]){
                    echo "Can't Edit cause there exists not finished order.";
                    $EditRight = FALSE;
                }
            }
        }

        if(!$EditRight){
            //script fail
            echo "<script>
            alert('Can't Edit cause there exists not finished order. ')
            </script>";
            echo "<meta http-equiv='Refresh' content='3;URL=$nav_url'>";
            exit();    
        }


        if(!empty($_POST['new_price']) && !empty($_POST['new_quantity'])){           
            $new_price = $_POST['new_price'];
            $new_quantity = $_POST['new_quantity'];         
            $san_price = mysqli_real_escape_string($conn, $new_price);
            $san_quantity = mysqli_real_escape_string($conn, $new_quantity);
            $sql = "UPDATE product SET price=$san_price, quantity =$new_quantity WHERE PID=$meal_id;"; 
            $conn->query($sql);
        }
        else if(!empty($_POST['new_price'])){
            $new_price = $_POST['new_price'];       
            $san_price = mysqli_real_escape_string($conn, $new_price);  
            $sql = "UPDATE product SET price=$san_price WHERE PID=$meal_id;";   
            $conn->query($sql);     

        }
        else if(!empty($_POST['new_quantity'])){
            $new_quantity = $_POST['new_quantity'];       
            $san_quantity= mysqli_real_escape_string($conn, $new_quantity);  
            $sql = "UPDATE product SET quantity=$san_quantity WHERE PID=$meal_id;"; 
            $conn->query($sql);         
        }     
        echo "<meta http-equiv='Refresh' content='10;URL=$nav_url'>";
        exit();

        
    }


?>