<?php
require 'private/config.php';
require 'private/timeremaining.php';

$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
$query_auctions = "select auction_number,title,area,reserve,reserve_met,highest_bid,closing_time
 from auctions order by UNIX_TIMESTAMP(closing_time)";
$result = mysql_query($query_auctions,$connection);

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
    echo "$imagelocation$image";
    $image = NULL;
  }else{
    echo 'images/tocheap.png';
  }
  echo '"alt="auction picture" width="115" height="86"></a></div>';
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


<p>/*static auctions for testing only */</p>

<div class="auctions">
  <div class="auctionimage" ><a href="auction.php?id=1">
<img src="images/tocheap.png" alt="auction picture"></a></div>
  <div class="auctiontext"><p class="auctionparagraphlink">
    <a href="auction.php?id=1">Used TV</a></p>
  <p class="area">Queenstown,Otago</p><p class="closingsoon">
Closes in 3 Seconds!</p></div>

<div class="reserve">
  <img src="images/yellowflag.png" alt="reserve met flag"></div>
  <p class="price">$200</p>
  <p class="bids"></p>
</div><!-- end auctions -->
<hr>

<div class="auctions">
  <div class="auctionimage" ><a href="auction.php?id=2">
<img src="auctions/img1.jpg" alt="auction picture"></a></div>
  <div class="auctiontext"><p class="auctionparagraphlink">
    <a href="auction.php?id=2">Nathan Rountree $1 res</a></p>
  <p class="area">Dunedin,Otago</p><p class="closingsoon">
Closes in 30mins</p></div>
  
<div class="reserve">
  <img src="images/redflag.png" alt="reserve met flag"></div>
<p class="price">$20</p>  
<p class="bids">4 bids</p>
</div><!-- end auctions -->
<hr>

<div class="auctions">
  <div class="auctionimage" ><a href="auction.php?id=3">
<img src="auctions/img2.jpg" alt="auction picture"></a></div>
  <div class="auctiontext"><p class="auctionparagraphlink">
    <a href="auction.php?id=3">Broken cshome server</a></p>
  <p class="area">Dunedin,Otago</p><p class="closing">Closes in 1 Day</p></div>

<div class="reserve">
  <img src="images/yellowflag.png" alt="reserve met flag"></div>
  <p class="price">$500</p>
  <p class="bids"></p>
</div><!-- end auctions -->
<hr>

<div class="auctions">
  <div class="auctionimage" ><a href="auction.php?id=4">
<img src="auctions/img4.png" alt="auction picture"></a></div>
  <div class="auctiontext"><p class="auctionparagraphlink">
    <a href="auction.php?id=4">Used comp212 assignment</a></p>
  <p class="area">Wellington</p><p class="closing">Closes in 3 Days</p></div>

<div class="reserve">
  <img src="images/redflag.png" alt="reserve met flag"></div>
  <p class="price">$200</p>
  <p class="bids">11 bids</p>
</div><!-- end auctions -->
<hr>

<div class="auctions">
  <div class="auctionimage" ><a href="auction.php?id=5">
<img src="auctions/img5.jpg" alt="auction picture"></a></div>
  <div class="auctiontext"><p class="auctionparagraphlink">
    <a href="auction.php?id=4">Flying V</a></p>
  <p class="area">Dunedin,Otago</p><p class="closing">Closes in 7 Days</p></div>

<div class="reserve">
  <img src="images/yellowflag.png" alt="reserve not met flag"></div>
  <p class="price">$300</p>
  <p class="bids">3 bids</p>
</div><!-- end auctions -->