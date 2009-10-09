<?php
//copied from http://www.javascriptkit.com/javatutors/externalphp2.shtml
//small changes were made as eregi is depreciated as of php 5.3
//(which I'm using), and will be removed in 6 so preg_match is used instead.
//PHP SCRIPT: getimages.php
include 'private/config.php';
if(!isset($_GET['n'])){
  header("Location:index.php");
  exit();
}
$auction_number = $_GET['n'];
$directory = $config['imagelocation'];
$images = $config['images'];
Header("content-type: application/x-javascript");

//This function gets the file names of all images in the current directory
//and ouputs them as a JavaScript array
function returnimages($dirname="/home/leslie/public_html/assign2/auctionimages/",$auction_number,$images) {
  $pattern="<".$auction_number."[_][0-9].jpg>"; //valid image extensions
  $files = array();
  $image = $images;
  $curimage=0;
  if($handle = opendir($dirname)) {
    while(false !== ($file = readdir($handle))){
      if(preg_match($pattern, $file)){ //if this file is a valid image
	//Output it as a JavaScript array element
	echo 'galleryarray['.$curimage.']="'.$image."".$file .'";';
	$curimage++;
      }
    }
    
    closedir($handle);
  }
  return($files);
}
echo 'var galleryarray=new Array();'; //Define array in JavaScript
returnimages($directory,$auction_number,$images) //Output the array elements containing the image file names
?> 