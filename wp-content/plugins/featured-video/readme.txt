=== Featured Video ===
Contributors: towonder
Donate link: http://www.to-wonder.com
Tags: video, featured, youtube, media
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 1.5.4

Featured video is exactly the same as a featured image. It allows you to easily link a YouTube or Vimeo video to a post.

== Description ==

Featured video allows you to add a YouTube or Vimeo video to one of your posts and get to it using the shortcode [featured-video],
next to that you can also embed it right in the code of your theme with the_post_video()!

the_post_video() returns your video standard with a 560x315 resolution. You can pass along the width and height, if
you would like to change this, so: the_post_video(600,400) will return the video with a resolution of 600x400.

Next to the width and height you can pass along the window mode (only for youtube) which defaults to transparent.
You can also edit the 'allowfullscreen' variable of the iframe. So a featured video with different width, height,
windowmode and allowfullscreen would be:
the_post_video(600,400,'window','');


There are a few other functions you can use in your theme (all parameters are optional):

	has_post_video(post_id) // same as has_post_thumbnail(), returns true or false.
	get_the_post_video(post_id, width, height, windowmode, allowfullscreen) // will not echo the video. Has the option to pass a post_id 
	the_post_video_thumbnail(post_id) // show the video thumbnail
	get_the_post_video_thumbnail(post_id) // will not echo the video thumbnail directly.
	the_post_video_image(post_id) // get the big version of the thumbnail
	get_the_post_video_image(post_id) //will not echo the video image directly

This plugin currently only supports YouTube and Vimeo and works with the url's of single video's.



== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `featured-video` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Copy/paste your embed-code in the textfield when you are editing a post.


== Frequently Asked Questions ==

= It keeps coming up blank =
Maybe the url of the video you are trying to load is a bit too long or complicated,
try the embedcode (on YouTube) or try the single video url on vimeo: http://vimeo.com/31332023

= I keep getting the error that my embedcode isn't right =
If your embedcode starts with an object-tag you're using an older version of the embedcode. Try looking for
the newer embedcode, it starts with the iframe tag.



== Screenshots ==


== Changelog ==

= 1.5.4 =
* Fixed the problems with Vimeo's new https protocol.

= 1.5 =
* Removed the post-type constraint.
* added the option to change the 'allowfullscreen' variable and wmode (last one only in youtube)

= 1.4 = 
* Added support for Vimeo
* Bugs have been fixed
* Added the [featured-video] shortcode

= 1.0 =
* First stable version