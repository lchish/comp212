<?php
require 'private/session.php';
require 'private/config.php';
$added = 1;
if(!isset($_GET['userhash'])){
  $added = -1;
}
if($added != -1){

  $connection = mysql_connect($config['host'],$config['username'],$config['password']);

  mysql_select_db($config['database'],$connection);//connect to database

  $clean_userhash = mysql_real_escape_string($_GET['userhash']);

  $query = "select username, dateofcreation from pending";
  $result = mysql_query($query,$connection);
  while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
    $username = $row['username'];
    $date = $row['dateofcreation'];
    //echo $username;
    if($clean_userhash == sha1($username.$date)){
      $valid = 1;
      break;
    }else{
      $valid = 0;
    }
  }
  $date = 5;
  $hash = sha1($clean_userhash.$date);
  if(isset($username) && $valid = 1){
    mysql_query("INSERT INTO users(username,passhash,administrator,blocked)
 select username,passhash,administrator,blocked from pending where 
username = '$username'",$connection);
    mysql_query("INSERT INTO userinfo(username,sex,firstname,lastname,email,
address,suburb,postcode,city,phone) SELECT username,sex,firstname,lastname,
email,address,suburb,postcode,city,phone from pending where 
username = '$username'");
mysql_query("DELETE FROM pending where username = '$username'");
//move the table with all the user data into the official users table
$added = 1;
  }
  else{
    $added = 0;
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sell it - The best online auctions. Browse, buy and sell on Sell It
</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
<div id="bodydiv">
<?php
include 'private/topnav.php';
include 'private/sidenav.php';
?>
<div id="content">
<p>

<?php
  if($added == 1){
    $_SESSION['auth'] = 'knownuser';
    $_SESSION['username'] = $row['username'];
    echo 'Your email has been sucessfully verified, you are now logged in!.
 Thank you for using sell it!';
  }else if($added == 0){
    echo 'verification failed';
  }else{
    echo 'This page is only meant to be used to validate emails please try the
 link in the email again.';
  }
?>
</p>
</div>
</div>
</body>
</html>