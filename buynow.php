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
$query_price = "SELECT highest_bid,buy_now,seller_username,title FROM auctions
 WHERE auction_number = '$clean_auctionnumber'";
$result_price = mysql_query($query_price,$connection);
$array_price = mysql_fetch_array($result_price);
$seller_username = mysql_real_escape_string($array_price['seller_username']);

$seller_email_address_array = mysql_fetch_array(mysql_query("SELECT email FROM
 userinfo,auctions WHERE seller_username = username AND 
 seller_username = '$seller_username'",$connection));
$seller_email_address = $seller_email_address_array['email'];
$title = mysql_real_escape_string($array_price['title']);
$purchase_price = mysql_real_escape_string($array_price['buy_now']);
if($array_price['buy_now'] < $array_price['highest_bid']){
  header("Location: index.php");
  exit();
}
//move and delete auction tables and send an email to the winner
$query_move = "INSERT INTO finished_auctions(auction_number,title,
winning_bidder,winning_bid,seller_username,closing_time)
 VALUES ('$clean_auctionnumber','$title','$clean_username','$purchase_price',
'$seller_username',NOW())";
$query_deleteauctions = "DELETE FROM auctions WHERE 
auction_number = '$clean_auctionnumber' ";
$query_deleteimages = "DELETE FROM auction_images WHERE 
auction_number = '$clean_auctionnumber'";
$query_deletebids = "DELETE FROM auction_bidders WHERE 
auction_number = '$clean_auctionnumber'";
mysql_query($query_move,$connection);
mysql_query($query_deleteauctions,$connection);
mysql_query($query_deleteimages,$connection);
mysql_query($query_deletebids,$connection);

$buyer_email_address_array = mysql_fetch_array(mysql_query("SELECT email FROM
 userinfo WHERE username = '$clean_username'",$connection));
$buyer_email_address = $buyer_email_address_array['email'];

$buyer_email_title = "Congratulations on winning the auction $title";
$buyer_email_message = "congrats on winning the auction";
$seller_email_title = "Your auction has been won using buy now";
$seller_email_message = "Your auction auction_title has been won by 
buyer_username";
if(mail($seller_email_address,$seller_email_title,$seller_email_message) &&
   mail($buyer_email_address,$buyer_email_title,$buyer_email_message)){
  $sent = 1;
}else{
   $sent = 0;
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
<p>Congratulations you have won the auction <strong><?php
  echo $title;?></strong> For: $<?php echo $purchase_price;?>
 Using Buy Now</p>
<p><a href="mailto:<?php echo $seller_email_address;?>" >Please send an
 email to the seller to sort out payment details</a></p>
<?php echo $sent;?>
</div>
</div>
</body>
</html>