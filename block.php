<?php
require 'private/session.php';
require 'private/config.php
if($_SESSION['admin'] != 1){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
if(isset($_GET['username']) && isset($_GET['block'])){
  $clean_username = mysql_real_escape_string($_GET['username']);
 }
else{
  header("Location: admin.php");
  exit();
}
if($_GET['block'] == 'block'){
 $b = 1;
 mysql_query("UPDATE users SET blocked = 1 WHERE username = '$clean_username'");
}
else if($_GET['block'] == 'unblock'){
 $b = 0;
 mysql_query("UPDATE users SET blocked = 0 WHERE username = '$clean_username'");
}
else if($_GET['block'] == 'makeadmin'){
 $b = 2;
 mysql_query("UPDATE users SET administrator = 1 WHERE username = '$clean_username'");
}
else if($_GET['block'] == 'delete'){
 $b = 3;
 mysql_query("DELETE FROM pending WHERE username= '$clean_username'");
}
else{
  header("Location: admin.php");
  exit();
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
  <p>User <?php echo $clean_username; ?> sucessfully <?php 
if($b == 1){echo 'blocked';} 
if($b == 0){echo 'unblocked';}
if($b == 2){echo 'made administrator';}
if($b == 3){echo 'deleted';}?>
</p>
<p>Click <a href="admin.php">here</a> to return</p>
</div>
</div>
</body>
</html>