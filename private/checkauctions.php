<?php
//script is run every minute to check for expired auctions and
//move them when expired.
require 'config.php';

$connection = mysql_connect($config['host'],$config['username'],
$config['password']);
mysql_select_db($config['database'],$connection);

$finished_auctions = mysql_query("SELECT * FROM auctions WHERE
 closing_time < NOW()",$connection);
if(mysql_num_rows($finished_auctions) > 0){
  while($row = mysql_fetch_array($finished_auctions)){
    echo $row['title']." has finished. Dealing too\n";
    $auction_title = $row['title'];
    $purchase_price = $row['highest_bid'];
    $clean_auction_number = mysql_real_escape_string($row['auction_number']);
    //always get seller email
    $clean_seller_username = mysql_real_escape_string($row['seller_username']
						      );
    $seller_email_array = mysql_fetch_array(mysql_query("SELECT email FROM 
userinfo WHERE username = '$clean_seller_username'", $connection));
    $seller_email = $seller_email_array['email'];
    //get buyer and seller email addresses,auction title
    if($row['reserve_met'] != 1){
      //send an email to the seller saying their auction was not won
      $seller_mail_title = "Your auction $auction_title was not won";
      $seller_mail_content = "Unfortunately your auction $auction_title 
was not won by anyone. Please consider relisting it";
      mail($seller_email,$seller_mail_title,$seller_mail_content);
      $sold = 0;
      $clean_buyer_username = "";
    }else{
      //get buyer email
    $clean_buyer_username = mysql_real_escape_string($row['highest_bidder']);
    $buyer_email_array = mysql_fetch_array(mysql_query("SELECT email FROM 
userinfo WHERE username = '$clean_buyer_username'", $connection));
    $buyer_email = $buyer_email_array['email'];
      //send an email to buyer and seller saying auction has finished
    $buyer_email_title = "Congratulations on winning auction $auction_title";
    $buyer_email_content = "Thank you for winning $auction_title, please
email the seller at $seller_email to arange payment for the items.";
    $seller_email_title = "Your auction $auction_title was won";
    $seller_email_content = "Congratulations on your auction $auction_title
it has been won by $clean_buyer_username please consider emailing them at
$buyer_email to finalise the purchase";
    mail($buyer_email,$buyer_email_title,$buyer_email_content);
    mail($seller_email,$seller_email_title,$seller_email_content);
    $sold = 1;
    }
    //move and delete auction tables
    $query_move = "INSERT INTO finished_auctions(auction_number,title,
winning_bidder,winning_bid,sold,seller_username,closing_time)
 VALUES ('$clean_auction_number','$auction_title','$clean_buyer_username','$purchase_price',
'$sold','$clean_seller_username',NOW())";
    $query_deleteauctions = "DELETE FROM auctions WHERE 
auction_number = '$clean_auction_number' ";
    $query_deleteimages = "DELETE FROM auction_images WHERE 
auction_number = '$clean_auction_number'";
    $query_deletebids = "DELETE FROM auction_bidders WHERE 
auction_number = '$clean_auction_number'";
    mysql_query($query_move,$connection);
    mysql_query($query_deleteauctions,$connection);
    mysql_query($query_deleteimages,$connection);
    mysql_query($query_deletebids,$connection);
  }
}
?>
