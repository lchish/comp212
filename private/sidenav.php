<div id="sidenavbar">
<?php
if(!isset($_SESSION['auth']) || $_SESSION['auth'] != 'knownuser'){
?>
  <p class = "login"><strong>Login:</strong></p>
  <div id="loginform">
    <form action="redirect.php" method="post">
      <p>Username:<input class="login" type="text" name="username"></p>
      <p>Password:<input class="login" type="password" name="password"></p>
      <div><input type="submit" value="" id="loginbutton"></div>
    </form>
    <?php
      if(isset($_GET['auth']) && $_GET['auth'] == 'fail'){
	echo '<p><strong>Login Failed!</strong</p>';
      }
	?>
  </div>
<p class = "createAccount">Or create an account</p>
<div><a href="newaccount.php">Create</a></div>
<?php 
   }
   else{
?>
<ul id="sideul">
<li class="sideli"><a href="editdetails.php">Edit your details</a></li>
<li class="sideli"><a href="biddedon.php">Recently bidded on</a></li>
<li class="sideli"><a href="myauctions.php">My auctions</a></li>


<li class="sideli"><a href="newauction.php">Start a new auction</a></li>
<?php
   if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
     echo '<li class="sideli">Hello most glorious administrator would you like 
to administer some users? Then click <a href="admin.php">here</a></li>';
   }
?>
</ul>
<?php
}/*end else*/?>
</div>