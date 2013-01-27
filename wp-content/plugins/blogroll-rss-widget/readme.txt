
=== Blogroll Widget with RSS Feeds ===
Contributors: Crazy Girl
Donate link: none
Tags: blogroll, bookmarks, links, last post, recent post, thumbnails, feed, widget, sidebar widget, atom, rss, sidebar, random, nofollow
Requires at least: 2.8
Tested up to: 3.4
Stable tag: 2.2

Displays the recent posts of your blogroll links via RSS Feeds in a customizable sidebar widget 

== Description ==

= GERMAN: =

* [Deutsche Plugin-Beschreibung auf officetrend.de](http://www.officetrend.de/2684/wordpress-plugin-blogroll-widget-with-rss-feeds/ "WordPress Plugin: Blogroll Widget with RSS Feeds")

= ENGLISH: =
This Wordpress Widget allows you to display the recent posts of your blogroll links via RSS Feeds as a sidebar widget.
The Plugin works without Javascript and without AJAX. It uses the Wordpress standard links database and honors the 
visible and target settings as defined for each link (private links are not shown, links are displayed in the same or 
in a new window as specified). The Plugin is easy to install, the Widget is simple to use and highly customizable. 
You can simply switch on / off, select or type in the various configurations and settings.

You can configure this Widget in the Wordpress Appearance Widgets SubPanel as follows:

* add an own title to the sidebar widget
* define how many items you want to display 
* choose the link category of the items (all links or one of your link categories)
* select the item order (link name ascending, link name descending, link id ascending, link id descending, random order)
* show the images entered to the respective links or let the plugin generate website thumbnails (via m-software.de) - NOT RECOMMENDED, as this service does not work properly anymore!
* define the image size
* show blogroll links
* add the 'rel=nofollow' attribute to the blogroll links
* define how many feed post links you want to display
* choose if you want to shorten the feed post link text and define the length in characters
* add the 'rel=nofollow' attribute to the feed post links
* show feed post excerpts
* define how many characters of the feed post excerpt you want to display

Before using the Blogroll Widget with RSS Feeds make sure, that you have entered the right RSS Addresses to your links in the Links 
Subpanel. Otherwise this Plugin will not work correctly. No item is shown when no RSS Address is entered! With this you 
have a further possibility to configure the Widget output. When you do not enter a RSS Address to a link, it will not be 
displayed in the Widget.

Alternative to the Wordpress Appearance Widgets SubPanel you can add and configure the Blogroll Widget with RSS Feeds directly 
in your theme file (e.g. sidebar.php). For details please see the installation tab.

**Blogroll Widget with RSS Feeds requires Wordpress Version 2.8 or higher**


= Available Languages =

* German
* English
* Italian - Thanks to talksina
* French - Thanks to [Ma&icirc;tre M&ocirc;](http://maitremo.fr/ "Ma&icirc;tre M&ocirc;")
* Belorussian - Thanks to [Marcis G.](http://pc.de/ "Marcis G.")
* Bulgarian - Thanks to [Web Geek](http://webhostinggeeks.com/ "Web Geek")


== Installation ==

1. Unzip the ZIP plugin file
2. Copy the `blogroll-widget-rss` folder into your `wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the Appearance Widgets SubPanel to add the Blogroll Widget with RSS Feeds to your sidebar and configure it


**PHP Code and Configuration:**

Alternative to the Wordpress Appearance Widgets SubPanel you can add and configure the Blogroll Widget with RSS Feeds directly 
in your theme file (e.g. sidebar.php). In this case call the function `<?php show_blogroll_widget_rss(); ?>` at the 
place in your sidebar you want to show it. This will display the Blogroll Widget with RSS Feeds with the default 
configurations. The widget output starts with `<ul><li>` and ends with `</li></ul>`. You can put anything what and as 
you want around it.

To configure the Blogroll Widget with RSS Feeds in the theme file, please add an array of settings to the function. Following the 
array with the defaults:
 
`<?php show_blogroll_widget_rss(  array(
	'show_items' => -1, 
	'category' => false,
	'item_order' => 'link_name ASC',
	'show_image' => 'show-no-images',
	'thumb_size' => 50,
	'show_link' => 0,
	'show_link_nf' => 0,
	'feed_items' => 1,
	'shorten_feedlink' => 0,
	's_f_length' => 20,
	'feed_link_nf' => 0,
	'show_summary' => 0,
	'summary_length' => 100 ) ); ?>` 


PHP configuration options: 

* show_items => **-1** displays all items, any other **number** displays the number amount of items
* category => **false** for all links, otherwise the **number** of the respective link category id
* item_order => either **link_name ASC**, or **link_name DESC**, or **link_id ASC**, or **link_id DESC**, or **rand()**
* show_image => either **show-no-images**, or **show-my-own-images**, or **create-thumbnails**
* thumb_size => any **number** greater than 10 defines the pixel size of the images
* show_link => **0** = no blogroll links, **1** =  display blogroll links
* show_link_nf => **0** = no 'rel=nofollow' attribute is added to blogroll links, **1** = adds 'rel=nofollow' attribute to blogroll links
* feed_items => any **number** between 1 and 10 defines how many feed post links are displayed
* shorten_feedlink => **0** no feed post link text shortening, **1** = shorten the feed post link text
* s_f_length => **number** of characters of feed post link text
* feed_link_nf => **0** = no 'rel=nofollow' attribute is added to feed post links, **1** = adds 'rel=nofollow' attribute to feed post links
* show_summary => **0** = no feed post excerpts, **1** = display feed post excerpts
* summary_length => any **number** between 10 and 999 defines how many characters of the feed post excerpts are displayed

In the array you only need to define the configurations differing to the defaults, for the other configurations 
the defaults are taken automatically. So if you only want to add the feed post excerpts with 100 characters, your PHP 
Code would be `<?php show_blogroll_widget_rss( array('show_summary' = 1) ); ?>`.


**Display Blogroll RSS Widget on a single page:**
If you would like to display the Blogroll RSS Widget on a single page (instead or additionally to the sidebar), you can 
do this in your page.php theme file. After the code `the_content();` you enter the PHP Code of the Blogroll RSS Widget 
with your individual configuration into a if clause statement group by using the 
[Wordpress Page Conditional Tag](http://codex.wordpress.org/Conditional_Tags#A_PAGE_Page "Page Conditional Tag"), e.g. for 
the single page with the ID 167: `if ( is_page('167') ) { your blogroll rss widget code }` 


== Frequently Asked Questions ==

= Where do I enter the RSS Addresses? =

1. Go to the `Links` Panel
2. Click `Edit` at the respective Link
3. Scroll down to the `Advanced` Box
4. In the field `RSS Address` type the respective RSS Address e.g. `http://www.crazytoast.de/feed/` or `http://feeds2.feedburner.com/plerzelwupp`
5. Be careful with the trailing slash / at the end of the RSS Address! A feed without trailing slash need to be entered 
without it, a feed with trailing slash need to be entered with it (see above examples). Any mistake can cause that no 
feed post is shown in the respective item of Blogroll RSS Widget.


= Why is there an empty place for the feed post of a blogroll link in the Widget output? =

An empty place for the feed post of a blogroll link reports a wrong entered RSS Address. I rather decided to leave the 
output empty in this cases than showing up an error message. An error message is not a lucky solution for your visitors. 
Go to the details of the respective blogroll link and correct the RSS Address.


= Why is the link *Thumbnails by M-Software.de* displayed at the bottom of my Blogroll RSS Widget? =

If you have chosen the option `Create and show thumbnails` in the Blogroll Widget with RSS Feeds, the thumbnails are generated 
automatically via m-software.de. This service is free of charge. As condition for using this service the 
link *Thumbnails by M-Software.de* has to be displayed.
Alternatively to `Create and show thumbnails` you can choose `Show my own images` and enter your own images to the respective links.


= Where can I enter my own images to blogroll links? =

1. Go to the `Links` Panel
2. Click `Edit` at the respective Link
3. Scroll down to the `Advanced` Box
4. In the field `Image Address` type the respective Address of the image. If you do not have own images you could enter here the 
gravatar address of the autohr, e.g. http://www.gravatar.com/avatar/ef5de17b226669a2a7a335ea8167e29d


== Screenshots ==

1. Blogroll Widget with RSS Feeds in the Wordpress Appearance Widgets SubPanel


== Changelog ==

= 2.2 =
* some minor changes

= 2.1 =
* some changes

= 2.0 =
* Removed donate link for author
* Name and URL Update (German plugin description updated)

= 1.9 =
* New language: Bulgarian. Thanks to [Web Geek](http://webhostinggeeks.com/ "Web Geek")

= 1.8 =
* Change of donate link feed address

= 1.7 =
* Some minor code corrections

= 1.6 =
* New language: Belorussian. Thanks to [Marcis G.](http://pc.de/ "Marcis G.")

= 1.5 =
* URL Update because of permalink changes
* Create thumbnails in 4:3 proportion

= 1.4 =
* Some SQL query improvements. Tanks to [Stefan Murawski](http://blog.murawski.ch/, "IT Bl&ouml;gg")

= 1.3 =
* New language: French. Thanks to [Ma&icirc;tre M&ocirc;](http://maitremo.fr/ "Ma&icirc;tre M&ocirc;")

= 1.2 =
* Small correction in SQL query. Thanks to [Stefan Murawski](http://blog.murawski.ch/ "IT Bl&ouml;gg")

= 1.1 =
* New language: Italian. Thanks to talksina

= 1.0 =
* Initial release
