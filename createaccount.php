<?php
require 'private/config.php';
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);
if(strlen($_POST['username']) != 0){//make sure username is not taken
  $clean_username = $_POST['username'];
  /* we have to use two queries here to get around a strange bug in mysql*/
  $userquery1 = "SELECT users.username FROM users
  WHERE users.username = '$clean_username'";
  $userquery2 = "SELECT pending.username FROM pending 
WHERE pending.username = '$clean_username'";
  $result1 = mysql_query($userquery1,$connection);
  $result2 = mysql_query($userquery2,$connection);
  if(isset($result1) || isset($result2)){//silences warnings
    $row1 = mysql_fetch_array($result1);
    $row2 = mysql_fetch_array($result2);
    if(mysql_num_rows($result1) != 0 || mysql_num_rows($result2) != 0){
      header("Location: newaccount.php?error=usernametaken");
      exit();//username taken
    }
  }
}
else{//redirect please enter a username
  header("Location: newaccount.php?error=username");
  exit();
}
if(strlen($_POST['password']) >= 6){
  $clean_password = mysql_real_escape_string($_POST['password']);
}
else{//redirect please enter a password
  header("Location: newaccount.php?error=password");
  exit();
}
if(isset($_POST['sex']) && ($_POST['sex'] == 'male' || $_POST['sex'] == 'female')){
  $clean_sex = mysql_real_escape_string($_POST['sex']);
  if($clean_sex == 'male')
  $clean_sex = 0;
  else if($clean_sex == 'female')
  $clean_sex = 1;
 }else{//please enter a valid sex
  header("Location: newaccount.php?error=sex");
  exit();
}
if(strlen($_POST['firstname']) != 0){
  $clean_firstname = mysql_real_escape_string($_POST['firstname']);
 }else{//please enter a firstname
  header("Location: newaccount.php?error=firstname");
  exit();
}
if(strlen($_POST['lastname'])!=0){
  $clean_lastname = mysql_real_escape_string($_POST['lastname']);
 }else{//please enter a lastname
  header("Location: newaccount.php?error=lastname");
  exit();
}
if(strlen($_POST['email'])!=0){
  $clean_email = mysql_real_escape_string($_POST['email']);
  $domain = strstr($clean_email, '@');
  if(strcmp($domain,"@cs.otago.ac.nz") == 0 || 
     strcmp($domain,"@student.otago.ac.nz") == 0 || 
     strcmp($domain,"@mailinator.com") == 0){
  }else{
  header("Location: newaccount.php?error=email");
  exit();
}
 }else{
  header("Location: newaccount.php?error=email");
  exit();
}
if(strlen($_POST['address'])!=0){
  $clean_address = mysql_real_escape_string($_POST['address']);
 }else{//please enter a address
  header("Location: newaccount.php?error=address");
  exit();
}
if(isset($_POST['suburb'])){
  $clean_suburb = mysql_real_escape_string($_POST['suburb']);
}
if(isset($_POST['postcode'])){
  $clean_postcode = mysql_real_escape_string($_POST['postcode']);
}
if(strlen($_POST['city'])!=0){
  $clean_city = mysql_real_escape_string($_POST['city']);
}else{
  header("Location: newaccount.php?error=city");
  exit();
}
if(strlen($_POST['phone'])!=0){
  $clean_phone = mysql_real_escape_string($_POST['phone']);
 }else{//please enter a phone number
  header("Location: newaccount.php?error=phone");
  exit();
}
mysql_query("INSERT INTO pending(username,passhash,administrator,blocked,sex
,firstname,lastname,email,address,suburb,postcode,city,phone,dateofcreation)
 VALUES ('$clean_username',sha('$clean_password'),0,0,'$clean_sex',
'$clean_firstname','$clean_lastname','$clean_email','$clean_address',
'$clean_suburb','$clean_postcode','$clean_city','$clean_phone',NOW())",
$connection);
?>
<?php
$result = mysql_query("SELECT dateofcreation FROM pending WHERE 
username = '$clean_username'");
$array = mysql_fetch_array($result);
$date = $array['dateofcreation'];
$hash = sha1($clean_username.$date);//hash should be impossible to break!

$title = "Thank you for signing up to sell it";
$message = "Thanks for signing up to complete the sign up process please click
http://dev212.otago.ac.nz:8080/~lchisholm/assign2/verifyemail.php?userhash=$hash";

if(mail($clean_email,$title,$message)){
  $sent = 1;
}else{
   $sent = 0;
}
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
<?php
  if($sent == 1){//note CHANGE AFTER UPLOADING!!! TO ==
    echo '<p>Thank you for signing up a email has been sent to your account 
containing all the information you need to validate your account</p>';
    /*echo "<a href=\"http://localhost/~leslie/project/verifyemail.php?
     *userhash=$hash\">here</a>";*/
  }else{
    echo '<p>Mail sending failed please try again.</p>';
  }
?>
</div>
</div>
</body>
</html>
