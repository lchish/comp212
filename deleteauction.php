<?php
require 'private/session.php';
require 'private/config.php';

$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
if(isset($_GET['id']) && isset($_SESSION['username'])){
  $auction_number = mysql_real_escape_string($_GET['id']);
  $clean_username = $_SESSION['username'];
}else{
  header("Location: index.php");
  exit();
}
$query = "SELECT auction_number,seller_username FROM auctions WHERE
 seller_username = '$clean_username' && auction_number = '$auction_number'";
$result = mysql_query($query,$connection);

if($_SESSION['admin'] != 1 && mysql_num_rows($result) != 1){
  header("Location: myauctions.php?error=auction not found or wrong user");
  exit();
}
mysql_query("DELETE FROM auctions WHERE auction_number = '$auction_number'");
mysql_query("DELETE FROM auction_bidders 
WHERE auction_number = '$auction_number'");
mysql_query("DELETE FROM auction_images 
WHERE auction_number = '$auction_number'");
//todo: figure out how to delete images here
header("Location: myauctions.php");
?>