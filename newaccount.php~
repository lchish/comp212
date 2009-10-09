<?php
require 'private/session.php';
/* Logged in users shouldn't be able to make
 * new accounts */
if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'knownuser' 
    && isset($_SESSION['username'])){
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	  "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sell it - Create new account</title>
    
    <link href="forms.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">
   <link rel="icon" type="image/png" href="favicon.png">
  </head>
  <body>
<div id="bodydiv">
   <?php include 'private/topnav.php';include 'private/sidenav.php';?>
<div id="content">
    <p id="mandatory">Mandatory fields are marked with a (
<span class="mandatoryStar">*</span>)</p>
<?php
   if(isset($_GET['error'])){
     $error = $_GET['error'];
     if($_GET['error'] == 'email'){
       echo "<p><strong>Valid email address domains are @mailinator.com, 
@student.otago.ac.nz and @cs.otago.ac.nz</strong></p>";
     }
     else if($_GET['error'] == 'password'){
       echo "<p><strong>Passwords must be 6 characters or longer</strong></p>";
     }
     else if($_GET['error'] == 'usernametaken'){
       echo "<p><strong>Error: Username already in use please try another
 one</strong></p>";
     }
     else{
       echo "<p><strong>Error: please enter a valid $error</strong></p>";
     }
   }
?>
      <form action="createaccount.php" method="post" id="createaccountform">
	<div class="textinput">

	  <label for="username" class="textlabel">Username: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="username" name="username" class="textfield"
		 maxlength="32" size="20">

	  <label for="password" class="textlabel">Password: 
	  <span class="mandatoryStar">*</span></label>
	  <input type="password" id="password" name="password"
		 class="textfield" maxlength="32" size="20">

	  <p id="sex">Sex:<span class="mandatoryStar">*</span></p>
	  <label for="male" class="radiolabel">male: </label>
	  <input type="radio" id="male" name="sex" value="male"  
		 class="radiobutton">
	  <label for="female" class="radiolabel">female: </label>
	  <input type="radio" id="female" name="sex" value="female" 
		 class="radiobutton">

	  <label for="firstname" class="textlabel">Firstname: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="firstname" name="firstname"
		 class="textfield" maxlength="32" size="20">

	  <label for="lastname" class="textlabel">Lastname: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="lastname" name="lastname"
		 class="textfield" maxlength="32" size="20">

	  <label for="email" class="textlabel">Email: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="email" name="email"
		 class="textfield" maxlength="32" size="20">

	  <label for="address" class="textlabel">Street address: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="address" name="address"
		 class="textfield" maxlength="32" size="20">

	  <label for="suburb" class="textlabel">Suburb: </label>
	  <input id="suburb" name="suburb"
		 class="textfield" maxlength="32" size="20">

	  <label for="postcode" class="textlabel">Post Code: </label>
	  <input id="postcode" name="postcode"
		 class="textfield" maxlength="32" size="20">

	  <label for="city" class="textlabel">City: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="city" name="city"
		 class="textfield" maxlength="32" size="20">

	  <label for="phone" class="textlabel">Phone number: 
	  <span class="mandatoryStar">*</span></label>
	  <input id="phone" name="phone"
		 class="textfield" maxlength="32" size="20">
	</div><!--//textinput div-->
	<div>
	  <button type="submit" class="create">Create</button>
	</div>
      </form>
    </div>
    </div>
  </body>
</html>
