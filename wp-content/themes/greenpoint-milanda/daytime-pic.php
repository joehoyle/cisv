<?php
// This script uses the server time.
// set the default timezone to use. Available since PHP 5.1
// List of supported timezones available at http://www.php.net/manual/en/timezones.php
// If your hosting is at different timezone, set your own timezone below and uncomment:
// date_default_timezone_set('Europe/Sofia');

$day = date ("w");
$hour = date ("G");
$minutes = date ("i");
$daypic = '<img src="' . get_template_directory_uri() . '/images/thinking.jpg"'.' alt="I am thinking, please, Do Not Disturb!" title="I am thinking, please, Do Not Disturb!" />'; // By default I am thinking
                if (($day==0) or ($day==6))
                {
		$daypic = '<img src="' . get_template_directory_uri() . '/images/driving.jpg"'.' alt="I am driving, please, Do Not Disturb!" title="I am driving, please, Do Not Disturb!" />'; // At the weekend
		}
           else if (($hour>7)&& ($minutes>45)) 
                {
                $daypic = '<img src="' . get_template_directory_uri() . '/images/thinking.jpg"'.' alt="I am thinking, please, Do Not Disturb!" title="I am thinking, please, Do Not Disturb!" />'; // Coffee Break on every hour between x.45 to x.00. I am Thinking at this time
                }
	else if (($hour>=0) && ($hour<=7))
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/sleeping.jpg"'.' alt="I am sleeping, please, Do Not Disturb!" title="I am sleeping, please, Do Not Disturb!" />'; // Sometimes I sleep between 0.00 - 8.00 AM
		}
	else if ($hour==8)
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/thinking.jpg"'.' alt="I am thinking, please, Do Not Disturb!" title="I am thinking, please, Do Not Disturb!" />'; // Morning Coffee Thinking between 8.00 - 9.00 AM
		}
	else if (($hour>=9) && ($hour<12))
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/working.jpg"'.' alt="I am working, please, Do Not Disturb!" title="I am working, please, Do Not Disturb!" />'; // I`m working at this time - 9.00-12.00 AM, if we can call it Work  
		}
	else if ($hour==12)
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/food.jpg"'.' alt="I am at table, please, Do Not Disturb!" title="I am at table, please, Do Not Disturb!" />'; // Lunch time between 12.00-13.00 
		}
	else if (($hour>12) && ($hour<18))
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/working.jpg"'.' alt="I am working, please, Do Not Disturb!" title="I am working, please, Do Not Disturb!" />'; // I`m working between 1.00-6.00 PM, like in the morning.
		}
	else if ($hour==18)
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/food.jpg"'.' alt="I am at table, please, Do Not Disturb!" title="I am at table, please, Do Not Disturb!" />'; // Dinner at 6.00 - 7.00 PM
		}
	else if (($hour>18) && ($hour<24))
		{
		$daypic = '<img src="' . get_template_directory_uri() . '/images/tv.jpg"'.' alt="I am watching TV, please, Do Not Disturb!" title="I am watching TV, please, Do Not Disturb!" />'; // Like a normal people, I am watching TV between 7.00 - 11.59 PM 
		}
        else {
   		echo $daypic;
		}
echo $daypic; 
?>
