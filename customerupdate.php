<?php
            require_once "config.php";
 

            $name = $age = $phone = $address = $email = "";
            $name_err = $age_err = $phone_err = $address_err = $email_err = "";
             
            
            if(isset($_POST["id"]) && !empty($_POST["id"])){
                $id = $_POST["id"];

                $input_name = trim($_POST["name"]);
                if(empty($input_name)){
                    $name_err = "Please enter a name.";
                } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                    $name_err = "Please enter a valid name.";
                } else{
                    $name = $input_name;
                }
                
                $input_age = trim($_POST["age"]);
                if(empty($input_age)){
                    $age_err = "Please enter the age.";     
                } elseif(!ctype_digit($input_age)){
                    $age_err = "Please enter a positive integer value.";
                } else{
                    $age = $input_age;
                }
            
                $input_phone = trim($_POST["phone"]);
                if(empty($input_phone)){
                    $phone_err = "Please enter a phone number.";     
                } elseif(!ctype_digit($input_phone)){
                    $phone_err = "Please enter a positive integer value.";
                } else{
                    $phone = $input_phone;
                }
                
                $input_address = trim($_POST["address"]);
                if(empty($input_address)){
                    $address_err = "Please enter an address.";     
                } else{
                    $address = $input_address;
                }
            
                $input_email = trim($_POST["email"]);
                if(empty($input_email)){
                    $email_err = "Please enter an email.";     
                } else{
                    $email = $input_email;
                }
                
               
                if(empty($name_err) && empty($address_err) && empty($age_err)  && empty($phone_err) && empty($email_err)){
                  $sql = "UPDATE customer SET cName=?, cAge=?, cPhone=?, cAddress=?, cEmail=? WHERE cID=?";
         
                  if($stmt = mysqli_prepare($con, $sql)){
                      // Bind variables to the prepared statement as parameters
                      mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_age, $param_phone, $param_address, $param_email, $param_id);
                      
                      // Set parameters
                      $param_name = $name;
                      $param_age = $age;
                      $param_phone = $phone;
                      $param_address = $address;
                      $param_email = $email;
                      $param_id = $id;
                      
                      // Attempt to execute the prepared statement
                      if(mysqli_stmt_execute($stmt)){
                          // Records updated successfully. Redirect to landing page
                          header("location: customerlist.php");
                          exit();
                      } else{
                          echo "Something went wrong. Please try again later.";
                      }
                  }
                   
                  // Close statement
                  mysqli_stmt_close($stmt);
                }
                mysqli_close($con);
            } else{
    
              if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                // Get URL parameter
                $id =  trim($_GET["id"]);
                
                // Prepare a select statement
                $sql = "SELECT * FROM customer WHERE id = ?";
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "i", $param_id);
                    
                    // Set parameters
                    $param_id = $id;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
            
                        if(mysqli_num_rows($result) == 1){
                            /* Fetch result row as an associative array. Since the result set
                            contains only one row, we don't need to use while loop */
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            
                            // Retrieve individual field value
                            $name = $row["name"];
                            $age = $row["age"];
                            $phone = $row["phone"];
                            $address = $row["address"];
                            $email = $row["email"];
                        } else{
                            // URL doesn't contain valid id. Redirect to error page
                            header("location: error.php");
                            exit();
                        }
                        
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    mysqli_stmt_close($stmt);
                }
                
                mysqli_close($con);
            }  else{
                // URL doesn't contain id parameter. Redirect to error page
                header("location: error.php");
                exit();
              }
            }

          ?>

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
      href="https://fonts.googleapis.com/css?family=Sulphur+Point&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script src="js/index.js"></script>
    <title>Customer Update</title>
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
    <section class="main d-flex justify-content-center align-items-center">
      <div class="container d-flex justify-content-center align-items-center">
        <div class="form-wrap">
          <h2>Customer's Information Update</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
              <label for="formGroupExampleInput">Full Name</label>
              <input
                name="name"
                type="text"
                class="form-control"
                id="formGroupExampleInput"
                placeholder="Enter your full name"
                value="<?php echo $name; ?>"
              /><span class="help-block"><?php echo $name_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
              <label for="formGroupExampleInput2">Age</label>
              <input
                name="age"
                type="number"
                class="form-control"
                id="formGroupExampleInput2"
                placeholder="Enter your age"
                value="<?php echo $age; ?>"
              /><span class="help-block"><?php echo $age_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
              <label for="formGroupExampleInput3">Phone(13 digits)</label>
              <input
                name="phone"
                type="tel"
                class="form-control"
                id="formGroupExampleInput3"
                placeholder="Enter your phone number"
                value="<?php echo $phone; ?>"
              /><span class="help-block"><?php echo $phone_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
              <label for="exampleFormControlTextarea1">Address</label>
              <textarea
                name="address"
                class="form-control"
                id="exampleFormControlTextarea1"
                rows="3" value="<?php echo $address; ?>"
              ></textarea><span class="help-block"><?php echo $address_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
              <label for="exampleInputEmail1">Email address</label>
              <input
                name="email"
                type="email"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Enter email"
                value="<?php echo $email; ?>"
              /><span class="help-block"><?php echo $email_err;?></span>
              <small id="emailHelp" class="form-text text-muted"
                >Your email will be kept in privacy</small
              >
            </div>
            <div class="form-group">
              <label for="exampleInputId">ID</label>
              <input
                type="password"
                class="form-control"
                id="exampleInputId"
                placeholder="Your agency ID"
                name="id"
                value="<?php echo $id; ?>"
              />
            </div>
            <button type="submit" name="submit" class="btn btn-outline-warning">
                  Update
                </button>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>
