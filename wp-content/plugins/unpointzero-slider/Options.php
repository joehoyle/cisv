<?php include("form_builder_func.php"); ?>
<div class="wrap">
	<h2>Slider setup</h2>
	<p>If you like our slider, please support us ! <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="TTV24MVLF5SEQ">
					<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
					</form></p>
	
	<div class="navi">
		<ul class="tabNavigation">
            <li><a href="#tab-shortcode">Embed & short code</a></li>
            <li><a href="#tab-general">General options</a></li>
			<li><a href="#tab-custompost">Custom post type options</a></li>
			<li><a href="#tab-style">Slider style</a></li>
			<li><a href="#tab-display">Display settings</a></li>
			<li><a href="#tab-customslide">Add custom slides link</a></li>
			<li><a href="#tab-autocss">Automatic CSS resizing</a></li>
			<li><a href="#tab-other">Other options</a></li>
			<li><a href="#tab-infos">Donate & Informations</a></li>
        </ul>
	</div>
	
	<form method="post" action="options.php">
	<?php settings_fields( 'upzslider_options' ); ?>
	<div class="tabs metabox-holder postbox" id="tab-shortcode">
	<fieldset name="general_options" class="options">	
	<h3 class="hndle"><span>Embed code and shortcode</span></h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Shortcode code is:
				</th>
				<td><?php form_input("shortcode_code","[upzslider]",80); ?>
					<p class="setting-description" style="margin:5px 10px;">Copy/Paste this code on your pages/posts to display the slider</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Embed code:
				</th>
				<td><?php form_input("embed_code","<?php do_shortcode('[upzslider usingphp=true]'); ?>",80);?>
					<p class="setting-description" style="margin:5px 10px;">Copy/Paste this code on your template to display the slider</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="font-weight:bold;color:red;padding-top:10px;">
					Warning
				</th>
				<td>
					<p class="setting-description" style="font-weight:bold;color:red; margin:5px 10px;">If using php integration add "usingphp=true" as above on your shortcode or the slider won't display.</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Shortcode for multiple slider:
				</th>
				<td><?php form_input("shortcode_multiple_code","[upzslider interid='category/page/taxonomy name, separated by comma' intertype='post OR page OR custom post type name' taxoname='custom taxonomy name']",80);?>
					<p class="setting-description" style="margin:5px 10px;">Copy/Paste this code on your template to display the slider.<br />If you want to display posts from category 3,5 and 20 from posts just write [upzslider interid="3,5,20" intertype="post"]</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Embed code for multiple slider:
				</th>
				<td><?php form_input("embed_code","<?php do_shortcode('[upzslider interid='category/page/taxonomy ids OR names' intertype='post OR page OR custom post type name' taxoname='custom taxonomy name']'); ?>",80);?>
					<p class="setting-description" style="margin:5px 10px;">Copy/Paste this code on your template to display the slider<br />If you want to display posts from category 3,5 and 20 from posts replace with [upzslider interid="3,5,20" intertype="post"]</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="tabs" id="tab-general">
	<div class="metabox-holder postbox">
	<h3>General options</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Page or posts or custom post type:
				</th>
				<td><?php form_radio("slider-type",array('1'=>"Posts",'2'=>"pages",'3'=>"Custom post type"),get_option('slider-type'));?>
					<p class="setting-description" style="margin:5px 10px;">Select to display pages of posts</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Names / IDs:
				</th>
				<td><?php form_input("slider-category-id",get_option('slider-category-id'));?>
					<p class="setting-description" style="margin:5px 10px;">Names / ID of the posts category (multiple allowed, coma separated) <b>OR</b> Pages names / Pages ID (multiple allowed, coma separated. Use IDs if you've issues)</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					IDs ?:
				</th>
				<td><?php form_checkbox("slider-nameorid","Using IDs","1",get_option('slider-nameorid')); ?>
					<p class="setting-description" style="margin:5px 10px;">If you're using IDs instead of names, check this case</p>
				</td>
			</tr>	
		</tbody>
	</table>
	</div>
	
	<div class="metabox-holder postbox">
	<h3>Only for POSTS settings</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Number of posts:
				</th>
				<td><?php
				form_radio("slider-fetch",array(-1=>"all blog posts (Warning can overload your server [not recommanded])",10=>"10 posts (recommanded if you display 2 to 8 slides  [default])",20=>"20 posts (recommanded if you display 8 to 16 slides)",0=>"Auto (recommanded if you always set a thumb to your posts)"),get_option('slider-fetch'));?>
					<p class="setting-description" style="margin:5px 10px;">Number of posts to check - this option prevents displaying of blank thumbnail</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
	
	<div class="tabs" id="tab-custompost">
	<div class="metabox-holder postbox">
	<h3>Only for custom posts</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Custom post name:
				</th>
				<td><?php form_input("slider-custompost-name",get_option('slider-custompost-name'));?>
					<p class="setting-description" style="margin:5px 10px;">Enter the name of your custom post</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Custom taxonomy name:
				</th>
				<td><?php form_input("slider-custompost-taxonomyname",get_option('slider-custompost-taxonomyname'));?>
					<p class="setting-description" style="margin:5px 10px;">Enter the name of your custom taxonomy</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>	
	
	<div class="tabs" id="tab-display">
	<div class="metabox-holder postbox">
	<h3>Display settings</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Number of slides:
				</th>
				<td><?php form_input("slider-view-number",get_option('slider-view-number')); ?>
					<p class="setting-description" style="margin:5px 10px;">Number of slides you want to display</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Max. number of characters for the title:
				</th>
				<td><?php form_input("slider-title-max-char",get_option('slider-title-max-char')); ?>
					<p class="setting-description" style="margin:5px 10px;">Number of characters you want to display for the title</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Max. number of characters for the title (thumbnail):
				</th>
				<td><?php form_input("slider-title-thumb-max-char",get_option('slider-title-thumb-max-char')); ?>
					<p class="setting-description" style="margin:5px 10px;">Number of characters you want to display for the title on the thumbnail. (Only if thumbnails activated)</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Description type:
				</th>
				<td><?php form_checkbox("slider-contentexrpt","Displaying excerpt ?",1,get_option('slider-contentexrpt')); ?>
					<p class="setting-description" style="margin:5px 10px;">Check this case if you want to display the excerpt instead of the content</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Max. number of caracters for the description:
				</th>
				<td><?php form_input("slider-desc-max-char",get_option('slider-desc-max-char')); ?>
					<p class="setting-description" style="margin:5px 10px;">Number of characters you want to display for the description</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="metabox-holder postbox">
	<h3>Advanced display settings</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Display:
				</th>
				<td><?php form_checkbox("slider-display-title","Title",true,get_option('slider-display-title')); ?>
					<?php form_checkbox("slider-display-desc","Description",true,get_option('slider-display-desc')); ?>
					<p class="setting-description" style="margin:5px 10px;">Uncheck to disable</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	
	</div>
	
	<div class="tabs" id="tab-style">
	<div class="metabox-holder postbox">
	<h3>Slider type</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Display thumbs:
				</th>
				<td><?php form_checkbox("slider-display-thumb","Thumbnails",true,get_option('slider-display-thumb')); ?>
					<p class="setting-description" style="margin:5px 10px;">Uncheck to disable thumbs. This will display a classic slider. Check on "Advanced CSS/JS settings" for advanced options.</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="metabox-holder postbox">
	<h3>Advanced CSS/JS settings</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Actions:
				</th>
				<td><?php form_checkbox("slider-mouseover-action","Mouseover action on thumb",true,get_option('slider-mouseover-action')); ?>
					<p class="setting-description" style="margin:5px 10px;">Rotate slide on mouseover. Check to enable (works only if thumbs enabled)</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Navigation type:
				</th>
				<td><?php
				$defaultadw = get_option('slider-display-adv-options');
				if($defaultadw==NULL) { $defaultadw=3; }
				form_select("slider-display-adv-options",array(0=>"Arrows",1=>"Navigation",2=>"Bubbles",3=>"OFF"),$defaultadw); ?>
					<p class="setting-description" style="margin:5px 10px;">Display arrows for previous / next navigation OR navigation (1,2,3...) OR small bubbles (CSS3 required).</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="metabox-holder postbox">
	<h3>Transition effect</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Transition effect
				</th>
				<td><?php $defaulttransitioneffect = get_option('slider-transitioneffect');
					if(($defaulttransitioneffect==NULL) || ($defaulttransitioneffect=="")) { $defaulttransitioneffect="fade"; }
					form_select("slider-transitioneffect",array("blindX"=>"blindX","blindY"=>"blindY","blindZ"=>"blindZ","cover"=>"cover","curtainX"=>"curtainX","curtainY"=>"curtainY","fade"=>"fade","fadeZoom"=>"fadeZoom","growX"=>"growX","growY"=>"growY","none"=>"none","scrollUp"=>"scrollUp","scrollDown"=>"scrollDown","scrollLeft"=>"scrollLeft","scrollRight"=>"scrollRight","scrollHorz"=>"scrollHorz","scrollVert"=>"scrollVert","shuffle"=>"shuffle","slideX"=>"slideX","slideY"=>"slideY","toss"=>"toss","turnUp"=>"turnUp","turnDown"=>"turnDown","turnLeft"=>"turnLeft","turnRight"=>"turnRight","uncover"=>"uncover","wipe"=>"wipe","zoom"=>"zoom"),$defaulttransitioneffect); ?>
					<p class="setting-description" style="margin:5px 10px;">Select the transition effect between slides</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Transition speed
				</th>
				<td>
					<?php $transitionspeed = get_option('slider-transitionspeed');
						if(($transitionspeed==null) || ($transitionspeed=="")) { $transitionspeed = 600; }
					form_input("slider-transitionspeed",$transitionspeed); ?>
					<p class="setting-description" style="margin:5px 10px;">The speed of the transition</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Transition timeout
				</th>
				<td>
					<?php $transitiontimeout = get_option('slider-transitiontimeout');
						if(($transitiontimeout==null) || ($transitiontimeout=="")) { $transitiontimeout = 3000; }
					form_input("slider-transitiontimeout",$transitiontimeout); ?>
					<p class="setting-description" style="margin:5px 10px;">Time between slides (in ms)</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	</div>
	
	<div class="tabs" id="tab-other">
	<div class="metabox-holder postbox">
	<h3>Other settings</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Non-latin languages:
				</th>
				<td><?php form_radio("slider-nonlatin",array(0=>"OFF[default]",1=>"ON"),get_option('slider-nonlatin')); ?>
					<p class="setting-description" style="margin:5px 10px;">Non-latin languages (set to ON only if you're displaying non-latin characters...japanese,hebrew...)</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Disable slider links
				</th>
				<td><?php form_checkbox("slider-disable-links","Disable links",true,get_option('slider-disable-links')); ?>
					<p class="setting-description" style="margin:5px 10px;">Check this to disable links.</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Activating links on thumbnails:
				</th>
				<td><?php form_checkbox("slider-linksonthumb","Links on thumbnails",true,get_option('slider-linksonthumb')); ?>
					<p class="setting-description" style="margin:5px 10px;">Activate links to post or page on thumbnails. Check to enable (works only if thumbs enabled)</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	<div class="metabox-holder postbox">
	<h3>Using custom meta (advanced users/developers only)</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Slider big image : custom meta name:
				</th>
				<td><?php form_input("slider-customthumb-metaname",get_option('slider-customthumb-metaname')); ?>
					<p class="setting-description" style="margin:5px 10px;">Enter here the name of your custom meta where the slider have to get the full images</br >Your custom meta have to return the full img code</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Slider mini image : custom meta name:
				</th>
				<td><?php form_input("slider-customthumb-mini-metaname",get_option('slider-customthumb-mini-metaname')); ?>
					<p class="setting-description" style="margin:5px 10px;">Enter here the name of your custom meta where the slider have to get the mini images</br >Your custom meta have to return the full img code</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Slider order : custom meta name:
				</th>
				<td><?php form_input("slider-customorderby",get_option('slider-customorderby')); ?>
					<p class="setting-description" style="margin:5px 10px;">Enter here the name of your custom meta for slider ordering</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
	
	<div class="tabs metabox-holder postbox" id="tab-infos">
	<h3>Donate & Informations</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Report a bug:
				</th>
				<td>
					<p class="setting-description" style="margin:5px 10px;"><a href="http://www.unpointzero.com/contact/" target="_blank">Report a bug</a></p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Buy me a Beer
				</th>
				<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="TTV24MVLF5SEQ">
					<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
					</form>
					<p class="setting-description" style="margin:5px 10px;">Support our plugin with donation. Thanks !</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Write a comment
				</th>
				<td><a href="http://www.unpointzero.com/unpointzero-slider#comment" target="_blank">Write a comment on our website</a>
					<p class="setting-description" style="margin:5px 10px;">If you like this plugin, tell us !</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Add a link on your pages
				</th>
				<td>
					<p class="setting-description" style="margin:5px 10px;">Support us to give you more free content ! Add a link to <a href="http://www.UnPointZero.com">http://www.UnPointZero.com</a> somewhere on your website !</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Follow us
				</th>
				<td>
					<a href="http://twitter.com/Unpointzero">On Twitter</a> - <a href="http://www.facebook.com/pages/UnPointZero/179727552061113">On Facebook</a>
					<p class="setting-description" style="margin:5px 10px;">On your social network</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="tabs metabox-holder postbox" id="tab-autocss">
	<h3>Automatic resizing</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Auto-resizing ?
				</th>
				<td><?php form_checkbox("slider-auto-resize-active","Auto-resize",true,get_option('slider-auto-resize-active')); ?>
					<p class="setting-description" style="margin:5px 10px;">Check this case to activate auto-resize</p>
				</td>
			</tr>
			
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Desired slider width
				</th>
				<td><?php form_input("slider-style-width",get_option('slider-style-width')); ?>
					<p class="setting-description" style="margin:5px 10px;">The width of the slider</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Margin between featured image and menu thumbnails (thumbnails ON)
				</th>
				<td><?php form_input("slider-style-featured-thumbnails-margin",get_option('slider-style-featured-thumbnails-margin')); ?>
					<p class="setting-description" style="margin:5px 10px;">Margin between featured image and menu thumbnails</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Margin between menu thumbnails and text (thumbnails ON)
				</th>
				<td><?php form_input("slider-style-text-thumbnails-margin",get_option('slider-style-text-thumbnails-margin')); ?>
					<p class="setting-description" style="margin:5px 10px;">Margin between menu thumbnails and text</p>
				</td>
			</tr>
						<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Width size ( in PX ) of the front image:
				</th>
				<td><?php form_input("slider-bigthumb-x",get_option('slider-bigthumb-x')); ?>
					<p class="setting-description" style="margin:5px 10px;">The width size of the big image</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Height size ( in PX ) of the front image:
				</th>
				<td><?php form_input("slider-bigthumb-y",get_option('slider-bigthumb-y')); ?>
					<p class="setting-description" style="margin:5px 10px;">The height size of the big image</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Width size ( in PX ) of the small image:
				</th>
				<td><?php form_input("slider-smallthumb-x",get_option('slider-smallthumb-x')); ?>
					<p class="setting-description" style="margin:5px 10px;">The width size of the small image (only if thumbnails enabled)</p>
				</td>
			</tr>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					Height size ( in PX ) of the small image:
				</th>
				<td><?php form_input("slider-smallthumb-y",get_option('slider-smallthumb-y')); ?>
					<p class="setting-description" style="margin:5px 10px;">The height size of the small image (only if thumbnails enabled)</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="tabs metabox-holder postbox" id="tab-customslide">
	<h3>Add custom slides</h3>
	<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
		<tbody>
			<tr>
				<th width="30%" valign="top" style="padding-top:10px;">
					<table border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td>Slider 1 link : <?php form_input("slider-customslide-url-1",get_option('slider-customslide-url-1')); ?></td>
						<td>Media 1 ID : <?php form_input("slider-customslide-image-1",get_option('slider-customslide-image-1')); ?></td>
						<td>Media 1 Title : <?php form_input("slider-customslide-title-1",get_option('slider-customslide-title-1')); ?></td>
						<td>Media 1 Description : <?php form_input("slider-customslide-desc-1",get_option('slider-customslide-desc-1')); ?></td>
						<td>Media 1 Position : <?php form_input("slider-customslide-pos-1",get_option('slider-customslide-pos-1')); ?></td>
					  </tr>
					</table>		
				</th>
				<td>
					<p class="setting-description" style="margin:5px 10px;">Full support with multiple custom slides coming soon.</p>
				</td>
			</tr>
		</tbody>
	</table>
	</div>	
	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>
</div>