<?php
require 'private/session.php';
require 'private/config.php';
if($_SESSION['admin'] != 1){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
$query_users = "select username,blocked,administrator from users";
$query_pending = "select username,dateofcreation from pending";
$result_users = mysql_query($query_users, $connection);
$result_pending = mysql_query($query_pending, $connection);
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
<h1>Current Users</h1>
<?php
  if(mysql_num_rows($result_users) > 0){
    echo '<ul>';
    while($row_users = mysql_fetch_array($result_users,MYSQL_ASSOC)){
      $value = $row_users['username'];
      $block = $row_users['blocked'];
      $admin = $row_users['administrator'];
      echo "<li style=\"clear:both;\">$value  ";
      if($admin != 1){
	echo " <a href=\"block.php?username=$value&amp;block=makeadmin\">
Make administrator</a>  ";
      }
      if($block == 0){
	echo "<a href=\"block.php?username=$value&amp;block=block\">Block
</a></li> ";
      }else{
	echo "<a href=\"block.php?username=$value&amp;block=unblock\">UnBlock
</a> </li>";
      }
    }
    echo '</ul>';
  }
?>
<h1 style="clear:both;">Pending Users</h1>
<?php
  if(mysql_num_rows($result_pending) > 0){
    echo '<ul>';
    while($row_pending = mysql_fetch_array($result_pending,MYSQL_ASSOC)){
      $value = $row_pending['username'];
      $date = $row_pending['dateofcreation'];
      echo "<li style=\"clear:both;\">$value Date of creation: $date 
<a href=\"block.php?username=$value&amp;block=delete\">Delete</a></li>";
    }
    echo '</ul>';
  }
?>
</div>
</div>
</body>
</html>