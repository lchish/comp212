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
$seller_username = $array_price['seller_username'];
$title = $array_price['title'];
if($array_price['buy_now'] < $array_price['highest_bid']){
  header("Location: index.php");
  exit();
}
//move and delete auction tables and send an email to the winner
$query_move = "INSERT INTO finished_auctions(auction_number,title,winning_bidder,winning_bid,seller_username,closing_time) VALUES SELECT auction_number,title,'$clean_username',buynow,seller_username,closing_time WHERE auction_number = '$clean_auctionnumber'";
$query_deleteauctions = "DELETE FROM auctions WHERE auction_number = '$clean_auctionnumber' ";
$query_deleteimages = "DELETE FROM auction_images WHERE auction_number = '$clean_auctionnumber'";
$query_deletebids = "DELETE FROM auction_bidders WHERE auction_number = '$clean_auctionnumber'";
$title = "Congratulations on winning the auction $title";

$message = "congrats on winning the auction";

if(mail($clean_email,$title,$message)){
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
  echo $title;?></strong> For: $<?php echo $array_price['buy_now'];?>
 Using buy Now</p>
<?php
  $sellers_email = mysql_fetch_array(mysql_query("select email FROM
 userinfo,auctions WHERE seller_username = username AND 
seller_username = '$seller_username'",$connection));
echo $sellers_email['email'];
echo $title;
?>
<p>Please send an email to the buyer to sort out payment details</p>
</div>
</div>
</body>
</html>