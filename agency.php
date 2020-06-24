<?php
    require_once "config.php";


    $name = $username = $password = $email = "";
    $name_err = $username_err = $password_err = $email_err = "";
      
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Please enter a valid name.";
        } else{
            $name = $input_name;
        }
        
        $input_username = trim($_POST["username"]);
        if(empty($input_username)){
            $username_err = "Please enter a username.";
        }else{
            $username = $input_username;
        }
        
        
        
        $input_password = trim($_POST["password"]);
        if(empty($input_password)){
            $password_err = "Please enter a password.";     
        } else{
            $password = $input_password;
        }
    
        $input_email = trim($_POST["email"]);
        if(empty($input_email)){
            $email_err = "Please enter an email.";     
        } else{
            $email = $input_email;
        }
        
        
        if(empty($name_err) && empty($username_err) && empty($password_err) && empty($email_err)){
            $sql = "INSERT INTO agency(aName, aEmail, username, pass) VALUES ('$name','$email' ,'$username', '$password')";

            $result = mysqli_query($con, $sql);
            if($result) {
              echo "<p>Them thanh cong</p>";
            } else {
              echo "<p>Them khong thanh cong</p>";
            }
    }
    mysqli_close($con);
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
    <title>Agency Register</title>
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
          <h2>Agency Information</h2>
          
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
              />
            </div>
            <div class="form-group">
              <label for="exampleInputUsername1">Username</label>
              <input
                name="username"
                type="text"
                class="form-control"
                id="exampleInputUsername1"
                placeholder="Enter username"
                value="<?php echo $username; ?>"
              />
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input
                name="password"
                type="password"
                class="form-control"
                id="exampleInputPassword1"
                placeholder="Password"
                value="<?php echo $password; ?>"
              />
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
              />
              <small id="emailHelp" class="form-text text-muted"
                >Your email will be kept in privacy</small
              >
            </div>
            
            <button type="submit" name="submit" class="btn btn-outline-warning">
                  Create
                </button>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>
