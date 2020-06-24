<?php 
  require_once "config.php";


  $username = $password = "";
  $username_err = $password_err = "";
    
  
  if($_SERVER["REQUEST_METHOD"] == "POST"){
  
      $input_username = trim($_POST["username"]);
      if(empty($input_username)){
          $username_err = "Please enter a username.";
      } else{
          $username = $input_username;
      }
      
      
      
      $input_password = trim($_POST["password"]);
      if(empty($input_password)){
          $password_err = "Please enter a password.";     
      } else{
          $password = $input_password;
      }
  
      if(empty($username_err) && empty($password_err) ){
       $query = "SELECT * FROM `heroku_2fb623d0782a230`.`agency` WHERE username='$username' and pass='$password'";
       $result = mysqli_query($con, $query) or die("Failed to query database" .mysqli_error($con));
       if($row = mysqli_fetch_array($result)){
        if($row['username'] == $username && $row['pass'] == $password){
          header("location: productview.php");
            exit();
        }else {
          echo "Something went wrong. Please try again later.";
        }
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
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Sulphur+Point&display=swap"
      rel="stylesheet"
    />
    <title>Agency Login</title>
  </head>
  <body>
    <section class="main d-flex justify-content-center align-items-center">
      <div class="container d-flex justify-content-center align-items-center">
        <div class="form-wrap">
          <h2>Agency Login Area</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input
              name="username"
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Enter username"
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
              />
            </div>
            <div class="col-auto">
              <div class="form-check mb-2">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="autoSizingCheck"
                />
                <label class="form-check-label" for="autoSizingCheck">
                  Remember me
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-outline-warning">
                  Login
            </button>
            <button type="button" class="btn btn-outline-warning">
                  <a href="agency.php">Create an account ?</a>
            </button>
          </form>
        </div>
      </div>
    </section>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <script src="js/index.js"></script>
  </body>
</html>
