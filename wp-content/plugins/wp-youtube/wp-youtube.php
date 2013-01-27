<?php
/*
Plugin Name: WP YouTube
Plugin URI: http://www.jenst.se/2007/11/01/wp-youtube
Description: WP YouTube allows you to control all the YouTube videos at the same time.
Author: Jens T&ouml;rnell
Version: 2.0
Author URI: http://www.jenst.se
*/

function wpytAddCSS(){
	echo '<link rel="stylesheet" type="text/css" href="'.get_option('siteurl').'/wp-content/plugins/wp-youtube/wp-youtube.css" />';
}
add_action('admin_head', 'wpytAddCSS');

function wpyoutube($tagnameInput, $youTubeID) { // Function to be called within themes
	$contentTotalOutput;
	$data_all = get_option("wpytProfileData");
	$explodera = explode (',', $data_all);
	
	for ($i=0; $i<sizeof($explodera)-1; $i++) {
		
		$tagname = explode ('%t=', $explodera[$i]);
		$tagname = explode ('%', $tagname[1]);
		$tagname = $tagname[0];
		
		if($tagname == $tagnameInput) {
			
			$autoplay = explode ('%a=', $explodera[$i]);
			$autoplay = $autoplay[1]{0};
			
			if ($autoplay == "y") { $autoplay = "1"; }
			
			$validxhtml = explode ('%v=', $explodera[$i]);
			$validxhtml = $validxhtml[1]{0};
			
			$relatedvideos = explode ('%r=', $explodera[$i]);
			$relatedvideos = $relatedvideos[1]{0};
			if ($relatedvideos == "y") {
				$relatedvideos = "1";
			}
			else {
				$relatedvideos = "0";
			}
			
			$border = explode ('%b=', $explodera[$i]);
			$border = $border[1]{0};
			if ($border == "y") { $border = "1"; }
			
			$width = explode ('%w=', $explodera[$i]);
			$width = explode ('%', $width[1]);
			$width = $width[0];
			
			$height = explode ('%h=', $explodera[$i]);
			$height = explode ('%', $height[1]);
			$height = $height[0];
			
			$color = explode ('%c=', $explodera[$i]);
			$color = $color[1]{0};
			
			if ($color == 1) { $color1 = "0xd6d6d6"; $color2 = "0xf0f0f0"; }
			else if ($color == 2) { $color1 = "0x3a3a3a"; $color2 = "0x999999"; }
			else if ($color == 3) { $color1 = "0x2b405b"; $color2 = "0x6b8ab6"; }
			else if ($color == 4) { $color1 = "0x006699"; $color2 = "0x54abd6"; }
			else if ($color == 5) { $color1 = "0x234900"; $color2 = "0x4e9e00"; }
			else if ($color == 6) { $color1 = "0xe1600f"; $color2 = "0xfebd01"; }
			else if ($color == 7) { $color1 = "0xcc2550"; $color2 = "0xe87a9f"; }
			else if ($color == 8) { $color1 = "0x402061"; $color2 = "0x9461ca"; }
			else if ($color == 9) { $color1 = "0x5d1719"; $color2 = "0xcd311b"; }
			else { $color1 = "0xd6d6d6"; $color2 = "0xf0f0f0"; }
			
			$tagtype = explode ('%tt=', $explodera[$i]);
			$tagtype = $tagtype[1]{0};
			
			if($tagtype==1) {
				$tagstart = "[" . $tagname . "]";
				$tagend = "[/" . $tagname . "]";
			}
			else if ($tagtype==2) {
				$tagstart = "<" . $tagname . ">";
				$tagend = "</" . $tagname . ">";
			}
			
			if ($validxhtml == 'y') {
				$contentTotalOutput = '<object type="application/x-shockwave-flash"';
				
				if ($width != "" || $height != "") { $contentTotalOutput .= ' style="'; }
				if ($width != "") { $contentTotalOutput .= 'width:'.$width.'px; '; }
				if ($width != "") { $contentTotalOutput .= 'height:'.$height.'px;'; }
				if ($width != "" || $height != "") { $contentTotalOutput .= '"'; }
				
				$contentTotalOutput .= ' data="http://www.youtube.com/v/'.$youTubeID;
				
				$contentTotalOutput .='&amp;rel='.$relatedvideos;
				if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
				if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
				if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
				
				$contentTotalOutput .= '">';
				$contentTotalOutput .= '<param name="movie" value="http://www.youtube.com/v/'.$youTubeID;
						
				if ($relatedvideos != "") { $contentTotalOutput .='&amp;rel='.$relatedvideos; }
				if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
				if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
				if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
							
				$contentTotalOutput .= '" /></object>';
				$contentTotalOutput .= $contentAfter[1]; //Efteråt
			}
			else {
				$contentTotalOutput = '<object';
				if ($width != "") { $contentTotalOutput .= ' width="'.$width.'"'; }
				if ($height != "") { $contentTotalOutput .= ' height="'.$height.'"'; }
				$contentTotalOutput .= '>';
				$contentTotalOutput .= '<param name="movie" value="http://www.youtube.com/v/'.$youTubeID;
				
				$contentTotalOutput .='&amp;rel='.$relatedvideos;
				if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
				if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
				if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
				
				$contentTotalOutput .= '"></param>';
				$contentTotalOutput .= '<param name="wmode" value="transparent"></param>';
				$contentTotalOutput .= '<embed src="http://www.youtube.com/v/'.$youTubeID;
				
				if ($relatedvideos != "") { $contentTotalOutput .='&amp;rel='.$relatedvideos; }
				if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
				if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
				if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }

				$contentTotalOutput .= '" type="application/x-shockwave-flash" wmode="transparent"';
				
				if ($width != "") { $contentTotalOutput .= ' width="'.$width.'"'; }
				if ($height != "") { $contentTotalOutput .= ' height="'.$height.'"'; }
				
				$contentTotalOutput .= '></object>';
				$contentTotalOutput .= $contentAfter[1]; //Efteråt
			}
		echo $contentTotalOutput;
			
		}
	}
}

function wpytRemoveProfileData() {
	delete_option("wpytProfileData");
}

function wpytDeleteOldData() {
	delete_option("option_youtube_width");
	delete_option("option_youtube_height");
	delete_option("option_youtube_tag_name");
	delete_option("option_youtube_tagtype");
	delete_option("option_youtube_color");
	delete_option("option_youtube_border");
	delete_option("option_youtube_related");
	delete_option("option_youtube_valid");
	delete_option("option_youtube_autoplay");
}

function wpytModifyContent($content){
	$contentTotalOutput; // Total utskrivning
	$data_all = get_option("wpytProfileData");
	$explodera = explode (',', $data_all);
	
	for ($i=0; $i<sizeof($explodera)-1; $i++) {
	
		$autoplay = explode ('%a=', $explodera[$i]);
		$autoplay = $autoplay[1]{0};
		
		if ($autoplay == "y") { $autoplay = "1"; }
		
		$validxhtml = explode ('%v=', $explodera[$i]);
		$validxhtml = $validxhtml[1]{0};
		
		$relatedvideos = explode ('%r=', $explodera[$i]);
		$relatedvideos = $relatedvideos[1]{0};
		if ($relatedvideos == "y") {
			$relatedvideos = "1";
		}
		else {
			$relatedvideos = "0";
		}
		
		$border = explode ('%b=', $explodera[$i]);
		$border = $border[1]{0};
		if ($border == "y") { $border = "1"; }
		
		$width = explode ('%w=', $explodera[$i]);
		$width = explode ('%', $width[1]);
		$width = $width[0];
		
		$height = explode ('%h=', $explodera[$i]);
		$height = explode ('%', $height[1]);
		$height = $height[0];
		
		$color = explode ('%c=', $explodera[$i]);
		$color = $color[1]{0};
		
		if ($color == 1) { $color1 = "0xd6d6d6"; $color2 = "0xf0f0f0"; }
		else if ($color == 2) { $color1 = "0x3a3a3a"; $color2 = "0x999999"; }
		else if ($color == 3) { $color1 = "0x2b405b"; $color2 = "0x6b8ab6"; }
		else if ($color == 4) { $color1 = "0x006699"; $color2 = "0x54abd6"; }
		else if ($color == 5) { $color1 = "0x234900"; $color2 = "0x4e9e00"; }
		else if ($color == 6) { $color1 = "0xe1600f"; $color2 = "0xfebd01"; }
		else if ($color == 7) { $color1 = "0xcc2550"; $color2 = "0xe87a9f"; }
		else if ($color == 8) { $color1 = "0x402061"; $color2 = "0x9461ca"; }
		else if ($color == 9) { $color1 = "0x5d1719"; $color2 = "0xcd311b"; }
		else { $color1 = "0xd6d6d6"; $color2 = "0xf0f0f0"; }
		
		$tagtype = explode ('%tt=', $explodera[$i]);
		$tagtype = $tagtype[1]{0};
		
		$tagname = explode ('%t=', $explodera[$i]);
		$tagname = explode ('%', $tagname[1]);
		$tagname = $tagname[0];
		
		if($tagtype==1) {
			$tagstart = "[" . $tagname . "]";
			$tagend = "[/" . $tagname . "]";
		}
		else if ($tagtype==2) {
			$tagstart = "<" . $tagname . ">";
			$tagend = "</" . $tagname . ">";
		}
		
	$contentBefore = explode($tagstart,$content);
	$contentTotalOutput = $contentBefore[0];
	
	for($j=1; $j<sizeof($contentBefore); $j++) {
		if ($validxhtml == 'y') {
			$contentAfter = explode ($tagend, $contentBefore[$j]);
			$youTubeID = $contentAfter[0];
			$contentTotalOutput .= '<object type="application/x-shockwave-flash"';
			
			if ($width != "" || $height != "") { $contentTotalOutput .= ' style="'; }
			if ($width != "") { $contentTotalOutput .= 'width:'.$width.'px; '; }
			if ($width != "") { $contentTotalOutput .= 'height:'.$height.'px;'; }
			if ($width != "" || $height != "") { $contentTotalOutput .= '"'; }
			
			$contentTotalOutput .= ' data="http://www.youtube.com/v/'.$youTubeID;
			
			$contentTotalOutput .='&amp;rel='.$relatedvideos;
			if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
			if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
			if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
			
			$contentTotalOutput .= '">';
			$contentTotalOutput .= '<param name="movie" value="http://www.youtube.com/v/'.$youTubeID;
					
			if ($relatedvideos != "") { $contentTotalOutput .='&amp;rel='.$relatedvideos; }
			if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
			if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
			if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
						
			$contentTotalOutput .= '" /></object>';
			$contentTotalOutput .= $contentAfter[1];
		}
		else {
			$contentAfter = explode ($tagend, $contentBefore[$j]);
			$youTubeID = $contentAfter[0];
			
			$contentTotalOutput .= '<object';
			if ($width != "") { $contentTotalOutput .= ' width="'.$width.'"'; }
			if ($height != "") { $contentTotalOutput .= ' height="'.$height.'"'; }
			$contentTotalOutput .= '>';
			$contentTotalOutput .= '<param name="movie" value="http://www.youtube.com/v/'.$youTubeID;
			
			$contentTotalOutput .='&amp;rel='.$relatedvideos;
			if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
			if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
			if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }
			
			$contentTotalOutput .= '"></param>';
			$contentTotalOutput .= '<param name="wmode" value="transparent"></param>';
			$contentTotalOutput .= '<embed src="http://www.youtube.com/v/'.$youTubeID;
			
			if ($relatedvideos != "") { $contentTotalOutput .='&amp;rel='.$relatedvideos; }
			if ($color1 != "") { $contentTotalOutput .='&amp;color1='.$color1.'&amp;color2='.$color2; }
			if ($border != "") { $contentTotalOutput .='&amp;border='.$border; }
			if ($autoplay != "") { $contentTotalOutput .= '&amp;autoplay='.$autoplay; }

			$contentTotalOutput .= '" type="application/x-shockwave-flash" wmode="transparent"';
			
			if ($width != "") { $contentTotalOutput .= ' width="'.$width.'"'; }
			if ($height != "") { $contentTotalOutput .= ' height="'.$height.'"'; }
			
			$contentTotalOutput .= '></object>';
			$contentTotalOutput .= $contentAfter[1]; //Efteråt
		}
	}
	$content = $contentTotalOutput;
}
return $content;
}

add_filter('the_content','wpytModifyContent');

function wpytAdmin(){
    if(isset($_POST['Submit'])){
		$data_all = get_option("wpytProfileData");
		$inputData = $_POST['codeString'];
		$explodera = explode (',', $data_all);
		
		update_option("wpytProfileData", $inputData);
        echo "<div id=\"message\" class=\"updated fade\"><p><strong>WP YouTube profiles saved</strong></p></div>"."\n";
    }

	if(isset($_POST['removeProfileDataButton'])) {
		wpytRemoveProfileData();
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>WP YouTube profile data deleted</strong></p></div>"."\n";
	}
	
	if(isset($_POST['deleteOldButton'])) {
		wpytDeleteOldData();
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>WP YouTube old profile data deleted</strong></p></div>"."\n";
	}
	
	echo '<script src="'.get_option('siteurl').'/wp-content/plugins/wp-youtube/wp-youtube.js"></script>'."\n";
	echo '<div class="wrap">'."\n";
	
	echo '<input type="hidden" value="'.get_option('siteurl').'" id="siteURL" />'."\n";
	
	$data_all = get_option("wpytProfileData");

	// Import old WP YouTube values
	$width = get_option("option_youtube_width");
	$height = get_option("option_youtube_height");
	$tagname = get_option("option_youtube_tag_name");
	$tagtype = get_option("option_youtube_tagtype");
	$color = get_option("option_youtube_color");
	$border = get_option("option_youtube_border");
	$relatedvideos = get_option("option_youtube_related");
	$validxhtml = get_option("option_youtube_valid");
	$autoplay = get_option("option_youtube_autoplay");
	
	if($data_all == "" && ($width != "" || $height != "" || $tagname != "" || $color != "" || $relatedvideos != "" || $validxhtml != "" || $autoplay != "" || $tagtype!="" )){

			for ($i=1;$i<10;$i++) {
				if ($color =="wpyt_color".$i){
					$color = $i;
				}
			}
			
			if ($tagtype =="wpyt_tagtype1"){ $tagtype = 1; }
			else if ($tagtype =="wpyt_tagtype2"){ $tagtype = 2; }
			
			if ($border=="on"){ $border = "y"; }
			if ($relatedvideos=="on"){ $relatedvideos = "y"; }
			if ($validxhtml=="on"){ $validxhtml = "y"; }
			if ($autoplay=="on"){ $autoplay = "y"; }
		
			$length = 2;
			
			for ($i=1; $i<$length; $i++) { $history .= $i . ","; }
			
			echo "<form method='post' action='".$_SERVER['PHP_self']."' name='options' target='_self'>"."\n";
			
			$inputData = get_option("wpytProfileData");
			echo '<textarea style="width: 100%; display: none;" id="codeString" name="codeString">';
			echo '%t=' . $tagname;
			echo '%w=' . $width;
			echo '%h=' . $height;
			echo '%c=' . $color;
			echo '%a=' . $autoplay;
			echo '%v=' . $validxhtml;
			echo '%r=' . $relatedvideos;
			echo '%b=' . $border;
			echo '%tt=' . $tagtype . ",";
			echo '</textarea>'."\n";
			
			echo '<textarea style="width: 100%; display: none;" id="history" name="history">' . $history . '</textarea>'."\n";
			
			echo '<h2>WP YouTube - Profile editor</h2>'."\n";
			echo '<p class="submit"><input class="button" style="float: left;" type="button" value="Create new profile" onclick="wpytAddElement('.$length.');" /><input type="submit" name="Submit" value="Save profiles &raquo;" onclick="return wpytOptionCheckEqual()" /></p>'."\n";
			
			echo '<div id="myDiv">'."\n";
			echo '<div id="introText" class="introText" style="color:black;';
			if(sizeof($explodera) != 1){ echo 'display:none;'; }
			echo '">Click <strong>"Create new profile"</strong> to get started or read the instructions</div>'."\n";
			echo '<noscript class="introText"><br />Your browser does not support javascript! WP YouTube 2 requires Javascript to administrate.<br />'."\n";
			echo 'If you can\'t use Javascript you can use <a href="http://www.jenst.se/2007/11/01/wp-youtube">WP YouTube 0.9</a></noscript>'."\n";
			
			$js = "n";
				$i=0;
				echo '<div id="my'.($i).'Div">'."\n";
					echo '<script type="text/javascript">document.write(wpytGenerateInnerHTML('.($i+1);
					echo ',"'.$tagname;
					echo '","'.$width;
					echo '","'.$height;
					if ($color!='%') { echo '","'.$color; } else { echo '","'.$color = ""; }
					if ($autoplay!='n') { echo '","'.$autoplay; } else { echo '","'.$autoplay = ""; }
					if ($border!='n') { echo '","'.$border; } else { echo '","'.$border = ""; }
					if ($relatedvideos!='n') { echo '","'.$relatedvideos; } else { echo '","'.$relatedvideos = ""; }
					if ($validxhtml!='n') { echo '","'.$validxhtml; } else { echo '","'.$validxhtml = ""; }
					if ($tagtype!='%') { echo '","'.$tagtype; } else { echo '","'.$tagtype = ""; }
					echo '","'.$js;
					echo '")); </script>'."\n";
				echo '</div>'."\n";
			
			echo '<input id="length" type="hidden" value="' . ($length-1) . '" />'."\n";
	//	}
	
		echo '<script type="text/javascript">alert(\'WP YouTube discovered a previous version of the plugin.\nClick \"Save profiles\" to use it!\n\nYou can remove old WP YouTube data at the bottom of this page.\');</script>';
	}
	else {
	
		$explodera = explode (',', $data_all);
		$length = sizeof($explodera);
		$history = "";
		
		for ($i=1; $i<$length; $i++) { $history .= $i . ","; }
		
		echo "<form method='post' action='".$_SERVER['PHP_self']."' name='options' target='_self'>"."\n";
		
		$inputData = get_option("wpytProfileData");
		echo '<textarea style="width: 100%; display: none;" id="codeString" name="codeString">' . $inputData . '</textarea>'."\n";
		echo '<textarea style="width: 100%; display: none;" rows="1" id="history" name="history">' . $history . '</textarea>'."\n";
		
		echo '<h2>WP YouTube - Profile editor</h2>'."\n";
		echo '<p class="submit"><input class="button" style="float: left;" type="button" value="Create new profile" onclick="wpytAddElement('.$length.');" /><input type="submit" name="Submit" value="Save profiles &raquo;" onclick="return wpytOptionCheckEqual()" /></p>'."\n";
		
		echo '<div id="myDiv">'."\n";
		echo '<div id="introText" class="introText" style="color:black;';
		if(sizeof($explodera) != 1){ echo 'display:none;'; }
		echo '">Click <strong>"Create new profile"</strong> to get started or read the instructions</div>'."\n";
		echo '<noscript class="introText"><br />Your browser does not support javascript! WP YouTube 2 requires Javascript to administrate.<br />'."\n";
		echo 'If you can\'t use Javascript you can use <a href="http://www.jenst.se/2007/11/01/wp-youtube">WP YouTube 0.9</a></noscript>'."\n";
		
		for ($i=0; $i<sizeof($explodera)-1; $i++) {
			$autoplay = explode ('%a=', $explodera[$i]);
			$autoplay = $autoplay[1]{0};
			$validxhtml = explode ('%v=', $explodera[$i]);
			$validxhtml = $validxhtml[1]{0};
			$relatedvideos = explode ('%r=', $explodera[$i]);
			$relatedvideos = $relatedvideos[1]{0};
			$border = explode ('%b=', $explodera[$i]);
			$border = $border[1]{0};
			$width = explode ('%w=', $explodera[$i]);
			$width = explode ('%', $width[1]);
			$width = $width[0];
			$height = explode ('%h=', $explodera[$i]);
			$height = explode ('%', $height[1]);
			$height = $height[0];
			$color = explode ('%c=', $explodera[$i]);
			$color = $color[1]{0};
			$tagtype = explode ('%tt=', $explodera[$i]);
			$tagtype = $tagtype[1]{0};
			$tagname = explode ('%t=', $explodera[$i]);
			$tagname = explode ('%', $tagname[1]);
			$tagname = $tagname[0];
			
			$js = "n";
			
			echo '<div id="my'.($i).'Div">'."\n";
				echo '<script type="text/javascript">document.write(wpytGenerateInnerHTML('.($i+1);
				echo ',"'.$tagname;
				echo '","'.$width;
				echo '","'.$height;
				if ($color!='%') { echo '","'.$color; } else { echo '","'.$color = ""; }
				if ($autoplay!='n') { echo '","'.$autoplay; } else { echo '","'.$autoplay = ""; }
				if ($border!='n') { echo '","'.$border; } else { echo '","'.$border = ""; }
				if ($relatedvideos!='n') { echo '","'.$relatedvideos; } else { echo '","'.$relatedvideos = ""; }
				if ($validxhtml!='n') { echo '","'.$validxhtml; } else { echo '","'.$validxhtml = ""; }
				if ($tagtype!='%') { echo '","'.$tagtype; } else { echo '","'.$tagtype = ""; }
				echo '","'.$js;
				echo '")); </script>'."\n";
			echo '</div>'."\n";
		}
		echo '<input id="length" type="hidden" value="' . ($length-1) . '" />'."\n";
	}
?>
</div>
<input type="hidden" value="0" id="theValue" />

<p class="submit">
<input id="removeAllButton" style="float: left;<?php if ($data_all == "") {	echo ' display:none;'; } ?>" type="button" class="button delete" value="Remove all profiles" onclick="wpytRemoveAll()" />
<input type="submit" name="Submit" value="Save profiles &raquo;" />
</p>

<h2>Instructions - Get started</h2>

<ol>
	<li><strong>Create new profile</strong><br />
The first thing you do is to create a new profile. The profile contains all the options you might need.<br />
ONE profile can be used with many videos, as many as you need.</li>
	<li><strong>Set a tag name</strong><br />
If you create more than one profile the tag names must be unique. Save the profile / profiles when you are done.</li>
	<li><strong>Find a YouTube ID</strong><br />
The ID is presented last of a YouTube URL:<br />
http://www.youtube.com/watch?v=<span style="color: red;">YjYT5OLoR8U</span></li>
	<li><strong>Put in a post or a page</strong><br />
Put tag name and YouTube ID together and place it in a post or a page.<br /><br />
<strong>Example:</strong><br />
[your_tagname]<span style="color: red;">YjYT5OLoR8U</span>[/your_tagname].<br /><br />
You can always see what your tag looks like in your profile.</li>
</ol>

<h2>Information - Options</h2>
<table style="width: 100%;">
	<tr>
		<td style="width: 50%;"><strong>Tagname</strong><br />
Use only numbers and letters (a-z and 0-9)</td>
		<td><strong>Width / Height</strong><br />
Maximum width and height</td>
	</tr>
	<tr>
		<td><strong>Color</strong><br />
The color of the YouTube player</td>
		<td><strong>Autoplay</strong><br />
Plays the video automatically on load</td>
	</tr>
	<tr>
		<td><strong>ValidXHTML</strong><br />
The embeded code validates with <a href="http://validator.w3.org">W3C HTML validator</a></td>
		<td><strong>Border</strong><br />
Border around the YouTube player</td>
	</tr>
	<tr>
		<td><strong>Tag type</strong><br />
[ ] works in both visual and code mode.<br />
&lt; &gt; works only in code mode.</td>
		<td><strong>Delete</strong><br />
Removes the profile. This action is not saved until you "Save profiles".</td>
	</tr>
</table><br />

<h2>Information - Misc</h2>
<table style="width: 100%;">
	<tr style="width: 50%;">
		<td><strong>Save profiles</strong><br />
Saves all your profiles into a single database field</td>
		<td><strong>Remove all profiles</strong><br />
Removes all your profiles. This action is not saved until you "Save profiles".</td>
	</tr>
	<tr>
		<td><strong>Advanced theme use</strong><br />
Put tag name and YouTube ID together and place it in your theme:<br />
&lt;?php&nbsp;wpyoutube&nbsp;('your_tagname','<span style="color: red;">YjYT5OLoR8U</span>'&nbsp;?&gt;
	</td>
	</tr>
</table><br />

<h2>Database clean up (for uninstall)</h2>
<p>If you for some reason want to uninstall WP YouTube, you can delete the related data saved into the database.</p>

<input type="submit" name="removeProfileDataButton" class="button delete" value="Delete Options" onclick="return confirm('Remove options from database? (cannot be undone)')" />

<br /><br />

<h2>Delete old version WP YouTube data</h2>
<p>If you have decided to use this version of WP YouTube, there is no need to keep old database values.</p>

<input type="submit" name="deleteOldButton" class="button delete" value="Delete Options" onclick="return confirm('Remove old WP YouTube data from database? (cannot be undone)')" />

</form>
</div>

<?php 
}

function wpytAddMenu() {
    add_submenu_page('edit.php', 'WP YouTube Profile Editor', 'YouTube Profiles', 10, __FILE__, 'wpytAdmin');
}
add_action('admin_menu', 'wpytAddMenu');
?>
