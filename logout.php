<?php
require 'private/session.php';

$_SESSION = array();
session_destroy();
setcookie('sellit',"",time()-3600,'~lchisholm/assign2/');
header("Location: index.php");
exit();
?>