<?php
require 'private/session.php';
require 'private/config.php';
//have to be logged in!
if($_SESSION['auth'] != 'knownuser'|| !isset($_SESSION['username'])){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(isset($_POST['auction_number'])){
  $clean_auctionnumber = mysql_real_escape_string($_POST['auction_number']);
  $clean_username = mysql_real_escape_string($_SESSION['username']);
}else{
  header("Location: index.php");
  exit();
}
$query_price = "SELECT highest_bid,buy_now FROM auctions 
WHERE auction_number = '$clean_auctionnumber'";
$result_price = mysql_query($query_price,$connection);
$array_price = mysql_fetch_array($result_price);
if($array_price['buy_now'] < $array_price['highest_bid']){
  header("Location: index.php");
  exit();
}
//move and delete auction tables and send an email to the winner
$query_move = "INSERT INTO finished_auctions(auction_number,title,winning_bidder,winning_bid,seller_username,closing_time) VALUES SELECT auction_number,title,'$clean_username',buynow,seller_username,closing_time WHERE auction_number = '$clean_auctionnumber'";
$query_deleteauctions = "DELETE FROM auctions WHERE auction_number = '$clean_auctionnumber' ";
$query_deleteimages = "DELETE FROM auction_images WHERE auction_number = '$clean_auctionnumber'";
$query_deletebids = "DELETE FROM auction_bidders WHERE auction_number = '$clean_auctionnumber'";
$email = "Congratulations on winning the auction $title";
echo  "Congratulations you have sucessfully won the auction";
?>