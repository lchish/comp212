<?php 

include 'private/config.php';
if(!isset($_GET['img']) || !isset($_GET['auction'])){
  exit();
}

$image_number = $_GET['img'];

$image_directory = $config['imagelocation'];
$server_image_location = $config['images'];
$auction_number = $_GET['auction'];
$pattern="<".$auction_number."[_]".$image_number.".jpg>"; //valid image extensions
if($image_number < 0){
  $count = 0;
  $pattern2 = "<".$auction_number."[_][0-9]*.jpg>";
  foreach(glob($image_directory."*.jpg") as $file){
    if(preg_match($pattern2,$file)){
      ++$count;
    }
  }
  echo "low".$count;
  exit();
}
foreach(glob($image_directory."*.jpg") as $file){
  if(preg_match($pattern,$file)){
    echo $server_image_location.$auction_number."_".$image_number.".jpg";
    exit();
  }
}
echo "high";

    /*    
if($handle = opendir($image_directory)){
  while(false !== ($file = readdir($handle))){
    if(preg_match($pattern,$file)){
      echo $server_image_location.$auction_number."_".$image_number.".jpg";
      closedir($handle);
      exit();
    }
  }
  closedir($handle);
  echo "high";*/
?>