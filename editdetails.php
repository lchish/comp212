<?php
require 'private/session.php';
require 'private/config.php';
if($_SESSION['auth'] != 'knownuser'){
  header("Location: index.php");
  exit();
}
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
mysql_select_db($config['database'],$connection);//connect to database
$username = $_SESSION['username'];
$query = "select * from userinfo where username = '$username'";
$result = mysql_query($query,$connection);
$row = mysql_fetch_array($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sell it - Edit your details</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="forms.css" rel="stylesheet" type="text/css">
      <script type="text/javascript" src="editdetails.js"></script>
    <link rel="icon" type="image/png" href="favicon.png">
  </head>
  <body>
    <div id="bodydiv">
    <?php
  include 'private/topnav.php';
  include 'private/sidenav.php';
?>
<div id="content">
    <p id="mandatory">Mandatory fields are marked with a (
    <span class="mandatoryStar">*</span>)</p>
<?php
    if(isset($_GET['error']) && $_GET['error'] == 'true'){
      echo '<p><strong>There was an error processing your 
details please check them and try again</strong></p>';
    }
?>
    <form action="processdetails.php" method="post" id="createaccountform">
      <div class="textinput">
	
	<label for="username" class="textlabel">Username: 
<span class="mandatoryStar">*</span></label>
	<input id="username" name="username" class="textfield"
	       maxlength="32" size="20"value=
"<?php echo $row['username']?>"><div id="usernameerr" class="error"></div>
	
	<label for="oldpassword" class="textlabel">Current Password: 
	<span class="mandatoryStar">*</span></label>
	<input type="password" id="oldpassword" name="oldpassword"
	       class="textfield" maxlength="32" size="20">
	    <div id="oldpassworderr" class="error"></div>

	  <label for="newpassword" class="textlabel">New Password: </label>
	<input type="password" id="newpassword" name="newpassword"
	       class="textfield" maxlength="32" size="20">

	  <p id="sex">Sex:<span class="mandatoryStar">*</span></p>
	  <label for="male" class="radiolabel">male: </label>
	  <input id="male" name="sex" type="radio" 
    <?php if($row['sex'] == 0){echo ' checked="checked" '; }?> 
		 value="male"  class="radiobutton">
          <label for="female" class="radiolabel">female: </label>
		 <input type="radio" 
		<?php if($row['sex'] == 1){ echo ' checked="checked" '; }?>
                 id="female" name="sex"  value="female"  class="radiobutton">
	    <div id="sexerr" class="error"></div>
	  
	  <label for="firstname" class="textlabel">Firstname: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="firstname" name="firstname"
		 class="textfield" maxlength="32" size="20" value=
		 "<?php echo $row['firstname']?>">
	    <div id="firstnameerr" class="error"></div>
	  
	  <label for="lastname" class="textlabel">Lastname: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="lastname" name="lastname"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['lastname']?>">
	    <div id="lastnameerr" class="error"></div>
	  
	  <label for="email" class="textlabel">Email: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="email" name="email"
		 class="textfield" maxlength="32" size="20" value=
		 "<?php echo $row['email']?>">
	    <div id="emailerr" class="error"></div>
	  
	  <label for="address" class="textlabel">Street address: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="address" name="address"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['address']?>">
	    <div id="addresserr" class="error"></div>
	  
	  <label for="suburb" class="textlabel">Suburb: </label>
	  <input id="suburb" name="suburb"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['suburb']?>">
	  
	  <label for="postcode" class="textlabel">Post Code: </label>
	  <input id="postcode" name="postcode"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['postcode']?>">
	  
	  <label for="city" class="textlabel">City: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="city" name="city"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['city']?>">
	    <div id="cityerr" class="error"></div>
	  
	  <label for="phone" class="textlabel">Phone number: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="phone" name="phone"
		 class="textfield" maxlength="32" size="20" 
		 value="<?php echo $row['phone']?>">
	    <div id="phoneerr" class="error"></div>
	</div><!--//textinput div-->
	<div>
	  <button type="submit" class="create">Edit</button>
	</div>
      </form>
    </div>
  </div>
 </body>
</html>