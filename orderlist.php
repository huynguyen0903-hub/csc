<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="css/style.css" />
    <script
      src="https://kit.fontawesome.com/3fd78d3b9b.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Sulphur+Point&display=swap"
      rel="stylesheet"
    />
    <script src="js/index.js"></script>
    <title>Order List</title>
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
    <section class="order-main">
      <div class="container">
        <h2>Orders List</h2>
        <span class="search"></span>
        <div
          class="table-wrap d-flex justify-content-center align-items-center"
        >
        <?php
          require_once "config.php";

          $sql = "SELECT * FROM orders";
          $sql2 = "SELECT * FROM ordersdetail";
          if($result = mysqli_query($con, $sql)) {
            if(mysqli_num_rows($result) > 0) {
              echo "<table class='table table-striped'>";
                echo "<thead>";
                  echo "<tr class='bg-info'>";
                    echo "<th scope='col'>ID</th>";
                    echo "<th scope='col'>Date</th>";
                    echo "<th scope='col'>Total</th>";
                    echo "<th scope='col'>Agency ID</th>";
                    echo "<th scope='col'>Customer ID</th>";
                  echo "</tr>";
                echo "</thead>";
              echo "<tbody>";
              while($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                    echo "<th scope='row'>". $row['oID'] ."</th>";
                    echo "<td>". $row['oDate'] ."</td>";
                    echo "<td>". $row['oPrice'] ."</td>";
                    echo "<td>". $row['aID'] ."</td>";
                    echo "<td>". $row['cID'] ."</td>";
                  echo "</tr>";
              }
              echo "</tbody>";
              mysqli_free_result($result);
            } else {
              echo "<p class='lead'><em>No records were found.</em></p>";
            }
          } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
          }

          if($result2 = mysqli_query($con, $sql2)) {
            if(mysqli_num_rows($result2) > 0) {
              echo "<table style='margin-left: 20px' class='table table-striped'>";
                echo "<thead>";
                  echo "<tr class='bg-info'>";
                    echo "<th scope='col'>Order ID</th>";
                    echo "<th scope='col'>Product ID</th>";
                  echo "</tr>";
                echo "</thead>";
              echo "<tbody>";
              while($row = mysqli_fetch_array($result2)) {
                  echo "<tr>";
                    echo "<th scope='row'>". $row['oID'] ."</th>";
                    echo "<td>". $row['pID'] ."</td>";
                  echo "</tr>";
              }
              echo "</tbody>";
              mysqli_free_result($result2);
            } else {
              echo "<p class='lead'><em>No records were found.</em></p>";
            }
          } else {
            echo "ERROR: Could not able to execute $sql2. " . mysqli_error($con);
          }
          mysqli_close($con);
        ?>
        </div>
      </div>
    </section>
  </body>
</html>
