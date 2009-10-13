<?php
require 'private/session.php';
require 'private/config.php';
require 'private/timeremaining.php';
require 'private/imagesize.php';

$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

if(isset($_GET['id'])){
  $auction_number = mysql_real_escape_string($_GET['id']);
 }else{
  header("Location: index.php");
  exit();
 }
$query = "SELECT * FROM auctions WHERE auction_number = '$auction_number'";
$queryimages = "SELECT * FROM auction_images WHERE auction_number = '$auction_number'";
$querybidders = "SELECT * FROM auction_bidders WHERE auction_number = '$auction_number'";

$result = mysql_query($query,$connection);
$resultimages = mysql_query($queryimages,$connection);
$resultbidders = mysql_query($querybidders,$connection);
//throw them back if auction not found
if(mysql_num_rows($result) ==0){
  header("Location: index.php");
  exit();
}
$row = mysql_fetch_array($result);
$x = 0;
while($rowimages = mysql_fetch_array($resultimages)){
  $images[$x] = $rowimages['auction_number']."_".$rowimages['image_number'].".jpg";
  $x++;
 }
$x = 0;
$title = $row['title'];
$area = $row['area'];
$category = $row['category'];
$content = $row['content'];
$reserve = $row['reserve'];
$buynow = $row['buy_now'];
$reserve_met = $row['reserve_met'];
$highest_bid = $row['highest_bid'];
$highest_bidder = $row['highest_bidder'];
$seller_username = $row['seller_username'];
$closing_date = $row['closing_time'];
$date = mysql_query("SELECT TIMEDIFF(closing_time,NOW()) FROM auctions
WHERE auction_number = '$auction_number'");
$date_array = mysql_fetch_array($date);
$closing_time = timeToText($date_array[0]);
$imagelocation = $config['images'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sell it - The best online auctions. Browse, buy and sell on Sell It
</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="auction.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="favicon.png">
  <?php if( isset($images) && count($images) > 1){?>
<script typt="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="auction.js"></script><?php } ?>
</head>
<body>
<div id="bodydiv">
<?php
include 'private/topnav.php';
include 'private/sidenav.php';
?>
<div id="content">
<?php
echo "<h1 id=\"auctiontitle\">$title</h1>";
//info bar containing current bid,and closing time
  echo "<div id=\"infobar\">";
if($reserve_met == 0){
  echo "<div class=\"pricing\">Start Price: \$$reserve</div>";
  echo "<span class=\"flag\"><img src=\"images/yellowflag.png\"
 alt=\"no reserve flag\"></span>";
  echo "<span id=\"reserve\">No reserve</span>";
 }else{
  echo "<div class=\"pricing\">Highest Bid: \$$highest_bid</div>";
  echo "<span class=\"flag\"><img src=\"images/redflag.png\" 
alt=\"reserve met flag\"></span>";
    echo "<span id=\"reserve\">Reserve Met</span>";
}
echo "<span>Closes: $closing_time</span>";
echo "</div>";//end infobar
echo "<form action=\"bid.php\" method=\"post\">";
echo "<div id=\"bidbar\">";
if($reserve_met == 0){
  echo "<div class=\"pricing\">Starting bid: $";
}else{
  echo "<div class=\"pricing\"><span class=\"buyspan\">Min next bid: $</span>";
}
?>

<input id="bidinput" type="text" name="bid" 
value="<?php echo $reserve > $highest_bid ? $reserve : $highest_bid + 1;?>" 
size="4"></div>
<input id="auctionnumber" type="hidden" name="auction_number" 
value="<?php echo $auction_number;?>">
  <?php if(isset($_SESSION['auth']) && $_SESSION['auth'] == 'knownuser'){?>
<input type="submit" id="bidbutton" value="click here to bid">
   <?php }?>
</div>
</form>
<?php
/* If the current highest bid is more than the buy now price
* do not display the buy now option*/
$query_price = "SELECT highest_bid,buy_now FROM auctions 
WHERE auction_number = '$auction_number'";
$result_price = mysql_query($query_price,$connection);
$array_price = mysql_fetch_array($result_price);
if(isset($buynow) && ($array_price['buy_now'] > $array_price['highest_bid'])){
    ?><form action="buynow.php" method="post">
<div id="buynowbar"><span class="buyspan">Buy Now Price $<?php echo $buynow;?>
  </span><?php if(isset($_SESSION['auth']) && 
$_SESSION['auth'] == 'knownuser'){?>
    <input type="submit" value="BuyNow" id="buynowbutton"><?php }?>
<input type="hidden" name="auction_number" 
value="<?php echo $auction_number;?>"></div></form>
<?php
  }?>
<?php
  if(isset($_GET['error'])){
    echo "<div id=\"auctionerror\">Error: ".$_GET['error']."</div>";
  }

echo "<div class=\"auctioncontent\">";
if(isset($images) && count($images) > 0){

echo "<div class=\"auctionimages\">";
$imagedimensions = getimagesize($config['imagelocation'].$images[$x]);
echo "<div id=\"auctionimage\"><img src=\"$imagelocation$images[0]\" 
id=\"image\" alt=\"auction image\"".imageResize($imagedimensions[0],
$imagedimensions[1],250)."></div>";
?>
<?php 
if(count($images) > 1){?>
<div id="leftarrow" class="arrow"><img src="images/left-arrow.png"
 alt="left arrow" width="34" height="39"></div>
<div id="rightarrow" class="arrow"><img src="images/right-arrow.png" 
alt="right arrow" width="34" height="39"></div>
  <?php } ?>
<?php
echo "</div>";
}
echo "$content</div>";
?>

<div id="closing">Closes on <?php echo $closing_date?></div>
<h2>Bid history</h2>
<div id="bidhistory">
<?php
  $bidders_result = mysql_query("SELECT * FROM auction_bidders 
WHERE auction_number = '$auction_number' ORDER BY bid DESC",$connection);
while($row = mysql_fetch_array($bidders_result)){
  echo "<div class=\"historyrow\">";
    echo "\$".$row['bid']."  ";
  echo $row['bidder'];
  echo "</div>";
  }
?>
</div>
</div>
</div>
</body>
</html>
