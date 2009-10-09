<?php
require 'private/session.php';
require 'private/config.php';
if(isset($_POST['auction_number'])){
  $tmp = $_POST['auction_number'];
}else{
  header("Location: index.php?");//fatal error
  exit();
}
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == 'unknownuser'){
  header("Location: auction.php?id=$tmp&error=you must be logged in to place a bid");
  exit();
 }

$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(isset($_POST['bid']) && isset($_POST['auction_number']) && strlen($_POST['bid']) < 7){
  $clean_bid = mysql_real_escape_string($_POST['bid']);
  $auction_number = mysql_real_escape_string($_POST['auction_number']);
  $bidder = mysql_real_escape_string($_SESSION['username']);
}else{
  header("Location: auction.php?id=$auction_number&error=invalid bid");
  exit();
}
$query_highest_bid = "SELECT highest_bid FROM auctions WHERE auction_number = $auction_number";
$result_highest_bid = mysql_query($query_highest_bid,$connection);
$highest_array = mysql_fetch_array($result_highest_bid);
$highest_bid = $highest_array[0];
//make sure bid is greater than previous bids if there are previous bids
if($highest_bid != null){
  if($highest_bid >= $clean_bid){
    header("Location: auction.php?id=$auction_number&error=must be higher than previous bids");
    exit();
  }
}else{//no previous bid
  mysql_query("UPDATE auctions SET reserve_met = 1 WHERE auction_number = '$auction_number'",$connection);
}
mysql_query("UPDATE auctions SET highest_bid = '$clean_bid' WHERE auction_number = '$auction_number'",$connection);
mysql_query("UPDATE auctions SET highest_bidder = '$bidder' WHERE auction_number = '$auction_number'",$connection);
mysql_query("UPDATE auctions SET highest_bidder = '$bidder' WHERE auction_number = '$auction_number'",$connection);
mysql_query("INSERT INTO auction_bidders(auction_number,bidder,bid) VALUES('$auction_number','$bidder','$clean_bid')",$connection);
header("Location: auction.php?id=$auction_number");
?>