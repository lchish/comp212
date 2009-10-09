<?php
/*note taken from http://articles.sitepoint.com/article/image-resizing-php */
function imageResize($width, $height, $target) {

if ($width > $height) {
$percentage = ($target / $width);
} else {
$percentage = ($target / $height);
}
$width = round($width * $percentage);
$height = round($height * $percentage);
return "width=\"$width\" height=\"$height\"";
}
?>