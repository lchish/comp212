<?php

require 'private/config.php';
require 'private/session.php';
$error = "";
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(strlen($_POST['title']) > 0 ){
  $clean_title = mysql_real_escape_string($_POST['title']);
}else{
  $error = $error."Please enter a valid auction title ";
 }
if(strlen($_POST['area']) >  0){
  $clean_area = mysql_real_escape_string($_POST['area']);
 }else{
  $error = $error."Please enter your city/province ";
 }
if(strlen($_POST['category']) >  0){
  $clean_category = mysql_real_escape_string($_POST['category']);
 }else{
  $error = $error."Please enter a category ";
 }
if(strlen($_POST['reserve']) > 0 && strlen($_POST['reserve']) < 7 &&
   $_POST['reserve'] != '0'){
  $clean_reserve = mysql_real_escape_string($_POST['reserve']);
  $int_reserve = (int)$clean_reserve;
}else{
  $error = $error."Please enter a valid reserve price ";
}
if(isset($_POST['content'])){
  if(strlen($_POST['content']) <= 1000){
     $clean_content = mysql_real_escape_string($_POST['content']);
  }else{
    $error = $error."content must be less than 1000 characters";
  }
}
if(isset($_POST['buynow'])){
  if(strlen($_POST['buynow']) < 7 && strlen($_POST['buynow']) > 0
&& $_POST['buynow'] != '0'){
    $clean_buynow = mysql_real_escape_string($_POST['buynow']);
    $int_buynow = (int)$clean_buynow;
  }else{
    $error = $error."Please enter a valid buynow price";
  }
}
$username = $_SESSION['username'];
if(strlen($error) > 0){
  header("Location: newauction.php?error=$error");
  exit();
}
mysql_query("INSERT INTO auctions(title,area,content,category,reserve,
buy_now,reserve_met,seller_username,closing_time)
VALUES('$clean_title','$clean_area','$clean_content','$clean_category',
'$int_reserve','$int_buynow',0,'$username',ADDTIME(NOW(),'7 0:0:0'))",
$connection);
$auction_query = "SELECT auction_number FROM auctions 
ORDER BY auction_number DESC";//find the auction number
$auction_result = mysql_query($auction_query,$connection);
$auction_row = mysql_fetch_array($auction_result);
$auction_number =  $auction_row['auction_number'];
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
<p>Your auction has been started click <a href="auction.php?id=<?php echo $auction_number;
?>">here</a> to view it.</p>
<p>Or click <a href="uploadimage.php?id=<?php echo $auction_number;?>">here</a> to add photos to go with your auction</p>
</div>
</div>
</body>
</html>