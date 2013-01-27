/*

Theme Name: GreenPoint Milanda
Theme URI: http://www.milanda.eu/wordpress/greenpoint-milanda-13-wordpress-theme/
Description: GreenPoint Milanda 1.4 Wordpress Theme. Fixed width 980px, 3 columns. 6 sidebars - top, left, right, bottom, top-center, bottom-center. Widget Ready, AdSense ready. Picture in the header changes dynamically according different time of the day.
Version: 1.4
Author: Mila Vasileva
Author URI: http://www.milanda.eu/
Tags: fixed width, three columns, widgets, valid CSS, walid XHTML, widget ready, adsense ready, white, simple, left sidebar, right sidebar, top sidebar, bottom sidebar, white, green

	The CSS, XHTML and design is released under GPL:
	http://www.opensource.org/licenses/gpl-license.php

GREEN POINT
1 ? oz Rittenhouse 100 proof bonded rye (Red Hook works nicely as well)
? oz Punt e Mes
? oz yellow Chartreuse
1 dash orange bitters
1 dash Angostura bitters

Stir and strain into cocktail glass

Enjoy
M-)

	
*/


Theme works fine in Mozilla, IE6, IE7, Safari, Opera, Chrome. Valid XHTML, Valid CSS.

Fixed width - 980px, best for screen resolutions 1024x768 and up. Six sidebars, widget ready. 


Header - dimensions:
width:100%, height:200px;
Name and blog descriptions - align left

Daytime_pic
Picture dimensions 980x180px. 
The original .psd file of the DayTime Picture - in the "contrib" folder, if you want to customize.
Used font in the picture - "Monotype Corsiva".

The file, that dynamically changes the picture in the header is "daytime-pic.php".
There was comments inside. 
The script uses the server time.

Day Time as present:
Day of week - at the weekend (Saturday and Sunday) I`m not home, I`m driving. Picture - driving.jpg
1. Sleeping between 0.00 - 8.00 AM. Picture - sleeping.jpg
2. Coffee Drinking and Thinking between 8.00 - 9.00 AM, also every hour between õ.45 to õ.00. Picture - thinking.jpg
3. Working between 9.00 - 12.00 AM and 1.00 - 6.00 PM. Picture - working.jpg
4. At table between 12 - 1 and 6 -7 PM. Picture - food.jpg
5. At 7.00 - 11.59 PM - watching TV. Yes, Watching TV. Picture - tv.jpg

Topmenu
The horizontal menu bar in the Header. Shows "Home" link, list of Pages in Your Blog and RSS link. Edit header.php to change.

Six Sidebars, widget ready: They are:
sidebar_top.php - At the top of the content, under the Header. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 1.
sidebar_left.php - The Left column in the content. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 2.
sidebar_right.php - The Right column in the content. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 3.
sidebar_bottom.php - At the bottom of content. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 4.
sidebar_top_center.php - At the bottom of middlecolumn. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 5.
sidebar_bottom_center.php -At the bottom of middlecolumn. In "Administration -> Theme Edit -> Widgets" You see it as Sidebar 6.

Sidebar_top (Sidebar 1)
File - sidebar_top.php
Sidebar inserted in header.php.
Dimensions:
width:980px
Can use for Advertisements, Banners, Google Adsense, etc.
Contains 2 blocks width 480px each, with Banners and short descriptions. For Example - AdSense banner and other banner.


Sidebar_left (Sidebar 2) - The Left Column #leftcolumn
sidebar_left.php
Sidebar inserted in index.php (Main index template).
Dimensions:
width:160px


#middlecolumn - Middle column - Area for Posts.
Dimensions:
width:520px.
Be careful with the pictures You insert in the posts - they must have max-width 500px.


Sidebar_right (Sidebar 3) -The Right Column #rightcolumn
sidebar_right.php
Dimensions:
width:300px



Sidebar_bottom (Sidebar 4)
sidebar_bottom.php
Sidebar inserted in footer.php.
Dimensions:
width:980px
Can use for Advertisements, Banners, Google Adsense, etc.
Big AdSense Leaderboard.

Sidebar_top_center (Sidebar 5)
sidebar_top_center.php
Sidebar inserted at the top of middlecolumn.
Dimensions:
width:500px;
Special for AdSense 468x15px;


Sidebar_bottom_center (Sidebar 6)
sidebar_bottom_center.php
Sidebar inserted at the bottom of middlecolumn.
Dimensions:
width:500px;
Special for AdSense 468x15px;


************************

One Touch Theme Color Change - convert to BluePoint, YellowPoint or GreenPoint, whatever You want.
Just open the file "style.css" in Notepad or other HTML editor. Do following:
1. Ctrl-H (Find and replace) - 
find #ff0000 (this is the Red Color)
2. Replace All with Your Favourite Color - #ffff00 (Bright Yellow, for example).
3. Ctrl-S (Save)
4. Upload to server

Color codes you can find at http://www.w3schools.com/html/html_colors.asp

Wish You All The Best

M-)

