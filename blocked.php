<?php
require 'private/session.php';
$_SESSION = array();
session_destroy();
setcookie('sellit',"",time()-3600,'/~leslie/projects');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Sell it - The best online auctions. Browse, buy and sell on Sell It
</title>
</head>
<body> 
<div id="bodydiv">
<?php
   include 'private/topnav.php';
include 'private/sidenav.php';
?>
<div id="content">
<p>Sorry you have been blocked by an administor.</p>
<p>Please send an email to <a href="mailto:lchishol@cs.otago.ac.nz">
lchisholm@cs.otago.ac.nz</a> if you wish to be unblocked.</p>
</div>
</div>
</body>
</html>