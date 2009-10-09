<?php
require 'private/session.php';
require 'private/config.php';
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(isset($_POST['username'])){
  $clean_username = mysql_real_escape_string($_POST['username']);
 }
if(isset($_POST['password'])){
  $clean_password = mysql_real_escape_string($_POST['password']);
 }
$query = "select * from users where username = '$clean_username' 
AND passhash = sha('$clean_password')";
$result = mysql_query($query, $connection);
$row = mysql_fetch_array($result);

if(mysql_num_rows($result) == 1){
  if($row['blocked'] == 1){
    $_SESSION['auth'] = 'blocked';
    header("Location: blocked.php");
    exit();
  }
  if($row['administrator'] == 1){
    $_SESSION['admin'] = 1;
  }
  $_SESSION['auth'] = 'knownuser';
  $_SESSION['username'] = $row['username'];
  header("Location: index.php");
  exit;
}else{
  $_SESSION['auth'] = 'unknownuser';
  //echo $row['username'];
  header("Location: index.php?auth=fail");
  exit;
  }
?>