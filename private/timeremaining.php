<?php
  /* This code is taken from
   * http://www.codingforums.com/archive/index.php/t-146115.html
   * had a few bugs (missing $variablenames etc)
   * hoping this isn't a problem.
   */

function timeToText($time) {
  $t = explode(":",$time);
  $hours = $t[0];
  $minutes = $t[1];

  $DAYS_IN_MONTH = 30;
  $HOURS_IN_DAY = 24;
  $DAYS_IN_WEEK = 7;

  $MINIMUM_DAYS_FOR_RETURN_MONTH = 30;
  $MINIMUM_DAYS_FOR_RETURN_WEEKS = 7;
  $MINIMUM_HOURS_FOR_RETURN_HOURS = 1;

  if($hours > ($HOURS_IN_DAY * $MINIMUM_DAYS_FOR_RETURN_MONTH)) // More than 3 weeks
    {
      return round($hours/$DAYS_IN_MONTH/$HOURS_IN_DAY)." months ";
    }
  else if($hours > $HOURS_IN_DAY * $MINIMUM_DAYS_FOR_RETURN_WEEKS) // More than 5 days
    {
      return round($hours/$HOURS_IN_DAY/$DAYS_IN_WEEK)." weeks ";
    }
  else if($hours > $HOURS_IN_DAY) // More than 24 hours
    {
      return round($hours/$HOURS_IN_DAY)." days ";
    }
  else if($hours > $MINIMUM_HOURS_FOR_RETURN_HOURS) // More than 1 hour
    {
      return $hours." hours ";
    }
  else // Less than 1 hour
    {
      if($minutes != 0){
	return $minutes." minutes ";
      }
      else{
	return "Less than 1 minute";
      }
    }
}
?>