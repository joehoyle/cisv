<?php	
		if($intertype!=null && $intertype!='') {
		$slider_type = $intertype;
		}
		else {
		$slider_type = get_option('slider-type');
		}
		if($interid!=null && $interid!='') {
		$slider_cat_id = $interid;
		}
		else {
		$slider_cat_id = get_option('slider-category-id');
		}
		$slider_view_number = get_option('slider-view-number');
		$slider_title_max_char = get_option('slider-title-max-char');
		$slider_title_thumb_max_char = get_option('slider-title-thumb-max-char');
		if (($slider_title_thumb_max_char==NULL) || ($slider_title_thumb_max_char=="")) { $slider_title_thumb_max_char = $slider_title_max_char; }
		$slider_desc_max_char = get_option('slider-desc-max-char');

	if(get_option('slider-fetch')!=null)
		$slider_fetch = get_option('slider-fetch');
	elseif(get_option('slider-fetch')==0)
		$slider_fetch = $slider_view_number;
	else
		$slider_fetch = 10;		

	if(($slider_type==1) || ($slider_type==3)) {
	$allinfos = slider_getinfo_by_cat($slider_cat_id,$slider_view_number,$slider_fetch,$slider_title_max_char,$slider_title_thumb_max_char,$slider_desc_max_char);
	}
	else {
	$allinfos = slider_getpages($slider_cat_id,$slider_view_number,$slider_title_max_char,$slider_title_thumb_max_char,$slider_desc_max_char);
	}
	$permalist = $allinfos[0];
	$titlelist = $allinfos[1];
	$thumbtitlelist = $allinfos[2];
	$contentlist = $allinfos[3];
	$thumb = $allinfos[4];
	$thumb_mini = $allinfos[5];
	
if(((get_option('slider-display-adv-options'))==0 || (get_option('slider-display-adv-options'))==1 || (get_option('slider-display-adv-options'))==2)&& (get_option('slider-display-thumb'))!=true) {
	?>
	<div id="featured-navi">
		<?php if(get_option('slider-display-adv-options')==0) { ?>
		<a href="#"><span id="previousslide"></span></a>
		<a href="#"><span id="nextslide"></span></a>
		<?php
		}
		if((get_option('slider-display-adv-options')==1)||(get_option('slider-display-adv-options')==2)) { ?>
		<div id="nav-featured" <?php if(get_option('slider-display-adv-options')==2) { echo 'class="bubbles-nav"'; } ?>></div>
		<?php
		}
	}
	?>
<div id="featured" class="upzslider">
<?php
if((get_option('slider-display-thumb'))==true)
	{ ?>
	<ul id="upz-slideshow-navigation">	
	<?php
		for($i=0;$i<sizeof($permalist);$i++) {
			$ifrag = $i;
					if(((get_option('slider-customslide-url-1')!="") && (get_option('slider-customslide-image-1')!="")) && (get_option('slider-customslide-pos-1')==$j)) {
					$thumb_img = wp_get_attachment_image_src(get_option('slider-customslide-image-1'),'upz-small');
					$thumb_title = get_option('slider-customslide-title-1');
					$thumb_id = $i+1;
					echo "<li id=\"nav-fragment-$thumb_id\"><img src=\"$thumb_img[0]\" alt=\"$thumb_title\" />";
				
					if(get_option('slider-linksonthumb')==true) {
						echo "<a href=\"$permalist[$i]\" onclick=\"window.open('$permalist[$i]','_self');\">";
					}
					
					if ((get_option('slider-display-title'))==true) {
					echo "<span>$thumb_title</span>";
				}
					if(get_option('slider-linksonthumb')==true) {
						echo "</a>";
					}
					echo "</li>";
					$ifrag = $i+1;
				}
		
					echo "<li id=\"nav-fragment-$ifrag\">";
		
					if(get_option('slider-linksonthumb')==true) {
						echo "<a href=\"$permalist[$i]\" onclick=\"window.open('$permalist[$i]','_self');\">";
					}
					
					echo "$thumb_mini[$i]";
					if ((get_option('slider-display-title'))==true) {
						echo "<span>$thumbtitlelist[$i]</span>";
					}
				
					if(get_option('slider-linksonthumb')==true) {
						echo "</a>";
					}
				
					echo "</li>";
		}
	?>
	</ul>
	<div id="upz-slideshow-display">
	<?php
	}
for($j=0;$j<sizeof($permalist);$j++) {
				$jfrag = $j;
				if(((get_option('slider-customslide-url-1')!="") && (get_option('slider-customslide-image-1')!="")) && (get_option('slider-customslide-pos-1')==$j)) {
				$customslide_url = get_option('slider-customslide-url-1');
				$customslide_img = wp_get_attachment_image_src(get_option('slider-customslide-image-1'),'upz-big');
				$customslide_desc = get_option('slider-customslide-desc-1');
				$thumb_title = get_option('slider-customslide-title-1');
				$slide_id = $j+1;
				echo "<div id=\"fragment-$slide_id\" style=\"\"><a href=\"$customslide_url\" ><img src=\"$customslide_img[0]\" alt=\"$thumb_title\" /></a>";
				
				if ((get_option('slider-display-title'))==true || (get_option('slider-display-desc'))==true) {
				echo "<div class=\"info\">";
				
				if ((get_option('slider-display-title'))==true) {
				echo "<h2><a href=\"$customslide_url\" >$thumb_title</a></h2>";
				}
				if((get_option('slider-display-desc'))==true) {
					echo "<p><a href=\"$customslide_url\" >$customslide_desc</a></p>";
				}	
				echo "</div>";
				}
				echo "</div>";
				$jfrag = $j+1;
				}

				echo "<div id=\"fragment-$jfrag\" style=\"\"><a href=\"$permalist[$j]\" >$thumb[$j]</a>";
				
				if ((get_option('slider-display-title'))==true || (get_option('slider-display-desc'))==true) {
				echo "<div class=\"info\">";
				
				if ((get_option('slider-display-title'))==true) {
				echo "<h2><a href=\"$permalist[$j]\" >$titlelist[$j]</a></h2>";
				}
				if((get_option('slider-display-desc'))==true) {
					echo "<p><a href=\"$permalist[$j]\" >$contentlist[$j]</a></p>";
				}	
				echo "</div>";
				}
				echo "</div>";
	}

	
	if((get_option('slider-display-thumb'))==true)
	{ ?>
	</div>
	<?php
	}
	?>
</div>
<?php
if(((get_option('slider-display-adv-options'))==0 || (get_option('slider-display-adv-options'))==1 || (get_option('slider-display-adv-options'))==2)&& (get_option('slider-display-thumb'))!=true) {
	?>
	</div>
	<div style="clear:both;"></div>
	<?php
	}
	?>