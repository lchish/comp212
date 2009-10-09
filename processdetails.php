<?php
require 'private/session.php';
require 'private/config.php';

$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);

$username = $_SESSION['username'];
$query = "SELECT users.username, passhash,sex,firstname,
lastname,email,address,suburb,postcode,city,phone 
FROM userinfo,users WHERE users.username = '$username' ";
$result = mysql_query($query,$connection);
$row = mysql_fetch_array($result);

//big if statement checking they are who they are 
//and all the incoming data is corrent and set
if(isset($_POST['username']) && isset($_POST['oldpassword']) 
   && sha1($_POST['oldpassword']) ==
   $row['passhash'] && isset($_POST['sex']) && 
   ($_POST['sex']=='male' || $_POST['sex'] =='female') 
   && isset($_POST['firstname'])
   && isset($_POST['lastname']) && isset($_POST['email']) && 
   isset($_POST['address']) && isset($_POST['city']) && 
   isset($_POST['phone'])){//end big if

     $clean_username = mysql_real_escape_string($_POST['username']);
     if(isset($_POST['newpassword'])){
     $clean_password = mysql_real_escape_string($_POST['newpassword']);
	 }
     $clean_sex = mysql_real_escape_string($_POST['sex']);
     if($clean_sex == 'male')
       $clean_sex = 0;
     else if($clean_sex == 'female')//consider using loop
       $clean_sex = 1;
     $clean_firstname = mysql_real_escape_string($_POST['firstname']);
     $clean_lastname = mysql_real_escape_string($_POST['lastname']);
     $clean_email = mysql_real_escape_string($_POST['email']);
     $clean_address = mysql_real_escape_string($_POST['address']);
     $clean_suburb = mysql_real_escape_string($_POST['suburb']);
     $clean_postcode = mysql_real_escape_string($_POST['postcode']);
     $clean_city = mysql_real_escape_string($_POST['city']);
     $clean_phone = mysql_real_escape_string($_POST['phone']);
     if($clean_username != $row['username']){
       mysql_query("UPDATE users SET username = '$clean_username' 
where username = '$username'");
       mysql_query("UPDATE userinfo SET username = '$clean_username' 
where username = '$username'");
       $_SESSION['username'] = $clean_username;
     }
     if(isset($_POST['newpassword'])){
     if(sha1($clean_password) != $row['passhash']){
       mysql_query("UPDATE users SET passhash = sha('$clean_password') 
where username = '$username'");
     }}
     if($clean_firstname != $row['firstname']){
       mysql_query("UPDATE userinfo SET firstname = '$clean_firstname'
 where username = '$username'");
     }
     if($clean_sex != $row['sex']){
       mysql_query("UPDATE userinfo SET sex = '$clean_sex'
 where username = '$username'");
     }
     if($clean_lastname != $row['lastname']){
       mysql_query("UPDATE userinfo SET lastname = '$clean_lastname' 
where username = '$username'");
     }
     if($clean_email != $row['email']){
       mysql_query("UPDATE userinfo SET email = '$clean_email' 
where username = '$username'");
     }
     if($clean_address != $row['address']){
       mysql_query("UPDATE userinfo SET address = '$clean_address' 
where username = '$username'");
     }
     if($clean_suburb != $row['suburb']){
       mysql_query("UPDATE userinfo SET suburb = '$clean_suburb' 
where username = '$username'");
     }
     if($clean_postcode != $row['postcode']){
       mysql_query("UPDATE userinfo SET postcode = '$clean_postcode' 
where username = '$username'");
     }
     if($clean_city != $row['city']){
       mysql_query("UPDATE userinfo SET city = '$clean_city' 
where username = '$username'");
     }
     if($clean_phone != $row['phone']){
       mysql_query("UPDATE userinfo SET phone = '$clean_phone' 
where username = '$username'");
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
<p>Your details have been sucessfully changed. Thank you for using sell it!</p>
</div>
</div>
</body>
</html>
<?php
}

else{
  header("Location: editdetails.php?error=true");//send them back
  exit();
}
?>