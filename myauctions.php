<?php

require 'private/session.php';
require 'private/config.php';

$connection = mysql_connect($config['host'],$config['username'],$config['password']);

mysql_select_db($config['database'],$connection);
$clean_username = mysql_real_escape_string($_SESSION['username']);
$query = "SELECT title,auction_number FROM auctions WHERE seller_username = '$clean_username'";
$result = mysql_query($query,$connection);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sell it - The best online auctions. Browse, buy and sell on Sell It
</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="myauctions.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
<div id="bodydiv">
<?php
include 'private/topnav.php';
include 'private/sidenav.php';
?>
<div id="content">
<h1>Current auctions</h1>
<?php
  if(isset($_GET['error'])){
    echo "<p><strong>Error: ".$_GET['error']."</strong></p>";
  }
?>
<?php
if(mysql_num_rows($result) > 0){
  echo "<ul class=\"myauctions\">";
  while($row = mysql_fetch_array($result)){
    $title = $row['title'];
    $num = $row['auction_number'];
    echo "<li class=\"myauctionsli\" style=\"clear:both;\">Title: 
<a href=\"auction.php?id=$num\">$title  </a>";
    echo "<span class=\"\"style=\"margin-left:1em;\">
<a href=\"uploadimage.php?id=$num\">Upload image </a></span>";
    echo "<span class = \"\" style=\"margin-left:2em;\">
<a href=\"deleteauction.php?id=$num\">Delete auction</a></span></li>";
  }
  echo "</ul>";
}else{
?>
  <p>You do not have any autions running at the moment</p>
  <p><a href="newauction.php" >Would you like to start one</a></p>
<?php
}
?>
<h2>Finished auctions</h2>
<?php
$finished = mysql_query("SELECT * FROM finished_auctions
 WHERE seller_username = '$clean_username'",$connection);
if(mysql_num_rows($finished) > 0){
  echo "<ul class=\"myauctions\">";
  while($row = mysql_fetch_array($finished)){
    if($row['sold'] == 1){
    echo "<li style=\"clear:both;\"> Title: ".$row['title']." Winning bid: ".
      $row['winning_bid']." Winning bidder: ".$row['winning_bidder']."</li>";
    }
    else{
    echo "<li style=\"clear:both;\">Your auction <strong>".$row['title']."
</strong> did not meet the reserve price. Please consider relisting it.</li>";
    }
  }  
  echo "</ul>";
}else{
  echo "<p style=\"clear:both;\">None of your auctions have finished</p>";
}
?>
</div>
</div>
</body>
</html>
