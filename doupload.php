<?php

require 'private/session.php';
require 'private/config.php';
//have to be logged in!
if($_SESSION['auth'] != 'knownuser'|| !isset($_SESSION['username'])){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],$config['username'],
			    $config['password']);
mysql_select_db($config['database'],$connection);

if(!isset($_POST['auctionnumber'])){
  header("Location: index.php");
  exit();
 }
$clean_auction_number = $_POST['auctionnumber'];
$query = "SELECT auction_number,image_number FROM auction_images 
WHERE auction_number = '$clean_auction_number' ORDER BY image_number DESC";
$result = mysql_query($query,$connection);
if(mysql_num_rows($result) > 0){
  $array = mysql_fetch_array($result);
  $image_number = $array['image_number'] + 1;
 }else{
  $image_number = 0;
 }
//$auction_number = $_POST['auction_number'];

if($_FILES['incoming']['error'] == UPLOAD_ERR_OK &&
   substr($_FILES['incoming']['name'], -4) == ".jpg" &&
   $_FILES['incoming']['size'] < 1000000){
  $imageinfo = getimagesize($_FILES['incoming']['tmp_name']);
  if($imageinfo['mime'] == 'image/jpeg'){
    move_uploaded_file($_FILES['incoming']['tmp_name'],
                       $config['imagelocation'].$clean_auction_number.
		       "_".$image_number.".jpg");
  }else {
    header("Location: uploadimage.php?id=?$clean_auction_number&error=server will only accept jpegs");
    exit();
  }
}else {
  header("Location: uploadimage.php?id=$clean_auction_number&error=wrong filename or bad extension only jpegs below 100kb will be accepted");
  exit();
 }
mysql_query("INSERT INTO auction_images(auction_number,image_number)
 VALUES('$clean_auction_number','$image_number') ",
	    $connection);
header("Location: uploadimage.php?id=$clean_auction_number&success=Image uploaded sucessfully would you like to upload another?");
?>
