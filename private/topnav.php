<div id="topnavbar">
  <div id="titleimg"><a href="index.php"><img src="images/title.png" 
alt="title picture" width="300" height="70"></a></div>
  <?php
    if(isset($_SESSION['username']) && $_SESSION['auth'] == 'knownuser'){
     echo "<p id=\"greeting\">Hi ";
     echo $_SESSION['username'];
     echo "!   ";
     echo '<a href="logout.php">Logout</a></p>';
     }
?>
<ul id="home" class="toplinks">
<li><strong><a href="index.php">Home:</a></strong></li>
</ul>
<ul id="buyingLinks" class="toplinks">
<li><strong class="buying">Buying:</strong></li>
<li><a href="watchlist.php">Watchlist</a></li>
<li><a href="won.php">Won</a></li>
<li><a href="lost.php">Lost</a></li>
</ul>
<ul id="sellingLinks" class="toplinks">
<li><strong class="buying">Selling:</strong></li>
<li><a href="selling.php">Items I'm selling</a></li>
<li><a href="sold.php">Sold</a></li>
<li><a href="unsold.php">Unsold</a></li>
</ul>
</div>
