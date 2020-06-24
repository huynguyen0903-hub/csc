<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

define('DB_SERVER', 'us-cdbr-iron-east-05.cleardb.net');

define('DB_USERNAME', 'bc43a16eefabf5');
define('DB_PASSWORD', '78de7c6e');
define('DB_NAME', 'heroku_2fb623d0782a230');
 
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>