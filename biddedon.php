<?php
require 'private/session.php';
require 'private/config.php';
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
  }
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
$username = mysql_real_escape_string($_SESSION['username']);
$query = "select auctions.title,auctions.auction_number,highest_bid,
highest_bidder FROM auctions,auction_bidders where 
auctions.auction_number = auction_bidders.auction_number and 
bidder = 'administrator' group by title ";
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
<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
<div id="bodydiv">
<?php
include 'private/topnav.php';
include 'private/sidenav.php';
?>
<div id="content">
  <h1 style="font-size:2em;">Auctions you recently bidded on</h1>
<?php 
  if(mysql_num_rows($result) > 0){
    echo "<ul>";
    while($row = mysql_fetch_array($result)){
      echo "<li style=\"clear:left;font-size:12pt;\">
Auction: <a href=\"auction.php?id=".$row['auction_number']."\">".
$row['title']."</a>  Highest Bid:".$row['highest_bid'];
      if($_SESSION['username'] != $row['highest_bidder']){
	echo "  Not the highest bidder";
      }else{
	echo "  Currently leading auction";
      }
      echo "</li>";
    }
    echo "</ul>";
  }
?>
</div>
</div>
</body>
</html>