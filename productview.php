<?php   
 session_start();  
 require_once "config.php";  

 if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
         
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_name'               =>     $_POST["hidden_name"],  
                     'item_price'          =>     $_POST["hidden_price"],  
                     'item_quantity'          =>     $_POST["quantity"]  
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="productview.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"],  
                'item_name'               =>     $_POST["hidden_name"],  
                'item_price'          =>     $_POST["hidden_price"],  
                'item_quantity'          =>     $_POST["quantity"]  
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  

 

 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["item_id"] == $_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="productview.php"</script>';  
                }  
           }  
      }  
 }  

 if(isset($_POST["submit"])) {
  $vardate = $_POST['date'];
  $vartotal = $_POST['price'];
  mysqli_query($con, "SET @@auto_increment_increment = 1;");
  $sql2 = "INSERT INTO orders(oDate, oPrice, aID, cID) VALUES('$vardate','$vartotal','3','14')";
  $result2 = mysqli_query($con, $sql2);
  
   $row2 = mysqli_insert_id($con);
   $addProduct = "INSERT INTO ordersdetail VALUES ";
   $cart = $_SESSION["shopping_cart"];
   for ($i = 0; $i < count($cart); ++$i){
     $item = $cart[$i];
     $addProduct .= "(" . $row2 . ", " . $item['item_id'] . ")";
     if ($i == count($cart) - 1) $addProduct .= ";";
     else $addProduct .= ",";
     
   }
   $result4 = mysqli_query($con, $addProduct);
  }


 ?>  


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <script
      src="https://kit.fontawesome.com/3fd78d3b9b.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Sulphur+Point&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>Products</title>
  </head>
  <body>
    <div id="mySidenav" class="sidenav">
      <a
        class="close"
        href="javascript:void(0)"
        class="closebtn"
        onclick="closeNav()"
        >x</a
      >
      <a href="customerlist.php">Customers List</a>
      <a href="orderlist.php">Orders List</a>
      <a href="customer.php">Customer Detail</a>
      <a href="productview.php">Products</a>
      <a href="agencylist.php">Agencies List</a>
    </div>
    <span class="open" onclick="openNav()"><i class="fas fa-bars"></i></span>

    <section class="view-main">
      <div class="container">
        <div class="row">
        <?php
          
          $sql = "SELECT * FROM product ORDER BY pID ASC";   
          if($result = mysqli_query($con, $sql)) {
            if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                
                  echo "<div class='col-12 col-md-4'>";
                    echo "<div class='box' data-toggle='collapse' href='#multiCollapseExample".$row['pID']."' role='button' aria-expanded='false aria-controls='multiCollapseExample".$row['pID']."'>";
                      echo "<img src='".$row['src']."'/>";
                    echo "</div>";
                    echo "<div class='collapse multi-collapse' id='multiCollapseExample".$row['pID']."'>";
                    echo "<form method='post' action='productview.php?action=add&id=".$row['pID']."'>";
                      echo "<div class='card card-body'>";
                        echo "<p> Product ID: ".$row['pID']. "</p>";
                        echo "<p>Product Name: ".$row['pName']."</p>";
                        echo "<p>Price: ".$row['pPrice']."</p>";
                        echo "<p>Category ID: ".$row['caID']."</p>";
                        echo "<p>Supplier ID: ".$row['sID']."</p>";
                        echo "<input type='number' name='quantity' class='form-control' value='1' />";
                        echo "<input type='hidden' name='hidden_name' value='".$row['pName']."' />";  
                        echo "<input type='hidden' name='hidden_price' value='".$row['pPrice']."' />"; 
                        echo "<button type='submit' name='add_to_cart' class='btn btn-outline-warning'>Add to order</button>";
                      echo "</div>";
                      echo "</form>";
                    echo "</div>";
                  echo "</div>";
                
                }
                mysqli_free_result($result);
                
              } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
              }
            }
          
            
          mysqli_close($con);
          
      ?>
        </div>
      </div>
    </section>
    <section class="order-adding">
      <div class="container">
        <div class="row">
          <table class="table">
            <thead class="thead-dark">
              <tr>
              <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                <?php   
                    if(!empty($_SESSION["shopping_cart"]))  
                    {  
                      
                      $total = 0;  
                      foreach($_SESSION["shopping_cart"] as $keys => $values)  {  
                        echo "<tr>";
                        echo "<th scope='row'> ".$values['item_id']."</th>";
                        echo "<td> ".$values['item_name']."</td>";
                        echo "<td> ".$values['item_quantity']."</td>";
                        echo "<td> ".$values['item_price']."</td>";
                        echo "<td> ".number_format($values['item_quantity'] * $values['item_price'], 2)."</td>";
                        echo "<td><a href='productview.php?action=delete&id=".$values['item_id']."'><span class='text-danger'>Remove</span></a></td>";
                        echo "</tr>";
                        $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                        
                      }  
                      echo "<tr> ";
                      echo "<td colspan='3' align='right'>Total</td>  ";
                      echo "<td align='right'>".number_format($total, 2)."</td>  ";
                      echo "</tr> ";
                    }  
                    
                    
                ?>  
            </tbody>
          </table>
        </div>
        <form  id="order" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="formGroupExampleInput">Order date</label>
              <input
                name="date"
                type="text"
                class="form-control"
                id="formGroupExampleInput"
                value="<?php echo $date = date("Y-m-d"); ?>"
                readonly
              />
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
              <label for="formGroupExampleInput">Total</label>
              <input
                name="price"
                type="number"
                class="form-control"
                id="formGroupExampleInput"
                value="<?php echo $total; ?>"
                readonly
              />
            </div>
            <button type="submit" name="submit" class="btn btn-outline-warning">
                <!-- <a href="orderlist.php">Create order</a> -->Create order
                </button>
        </form>
        
      </div>
    </section>
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <script src="js/index.js"></script>
  </body>
</html>
