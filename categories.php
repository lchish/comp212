<?php
require 'private/session.php';
require 'private/config.php';
require 'private/timeremaining.php';
require 'private/imagesize.php';

if(!isset($_GET['c'])){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],
			    $config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(strlen($_GET['c']) > 0){
  $clean_category = mysql_real_escape_string($_GET['c']);
}else{
  header("Locatoin: index.php");
  exit();
}
$query = "SELECT * FROM auctions WHERE category = '$clean_category' ORDER BY UNIX_TIMESTAMP(closing_time)";
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
  <h1 style="font-size:2em;"><?php echo $clean_category;?></h1>
  <?php 
//start code here...
while ($row = mysql_fetch_array($result)){
  $auction_number = $row['auction_number'];
  $query_images = "select * from auction_images where auction_number = '$auction_number'";
  $images = mysql_query($query_images,$connection);

  if(mysql_num_rows($images) > 0){
    $image_array = mysql_fetch_array($images);
    $image = $image_array['auction_number']."_".$image_array['image_number'].".jpg";
  }
  $auction_title = $row['title'];
  $auction_area = $row['area'];
  $auction_reserve = $row['reserve'];
  $auction_highest_bid = $row['highest_bid'];
  $auction_reserve_met = $row['reserve_met'];
  $date_result = mysql_query("SELECT TIMEDIFF(closing_time,NOW()) FROM auctions
WHERE auction_number = '$auction_number'");
  $date_array = mysql_fetch_array($date_result);
  $auction_closing_time = timeToText($date_array[0]);
  $imagelocation = $config['images'];
  echo '<div class="auctions"><div class="auctionimage">';
  echo " <a href=\"auction.php?id= $auction_number \"> ";
  echo '<img src="';
  if(isset($image)){
    echo "$imagelocation$image\"";
    $imagedimensions = getimagesize($config['imagelocation'].$image);
  }else{
    echo 'images/tocheap.png"';
  }
  echo "alt=\"auction picture\"";
  if(isset($imagedimensions)){ 
    echo imageResize($imagedimensions[0],$imagedimensions[1],115);
  }
  $imagedimensions = null;
  echo " ></a></div>";
  $image = NULL;
?>
<div class="auctiontext"><p class="auctionparagraphlink">
<a href="auction.php?id=<?php echo "$auction_number\">$auction_title";?></a></p>
<p class="area"><?php echo $auction_area;?></p><p class="closinglater">
<?php echo $auction_closing_time;?></p></div>
<div class="reserve">
  <img src="
   <?php if($auction_reserve_met == 0){
    echo 'images/yellowflag.png" alt="reserve not met flag">';
  }else{
    echo 'images/redflag.png" alt="reserve met flag">';
  }
?></div>
  <p class="price">$<?php
if($auction_reserve > $auction_highest_bid){
echo $auction_reserve;
}else{
echo $auction_highest_bid;
}
?></p>
  <p class="bids"></p>
</div><!-- end auctions -->
<hr>
<?php
}//end while loop
?>

</div>
</div>
</body>
</html>