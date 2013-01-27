function wpytOptionCheckEqual (){
		var codeString = document.getElementById('codeString').value;
		var splitCode = codeString.split("%t=");
		totalCount = splitCode.length-1;
		var splitCodeText;
		var splitText1;
		var equalName = false;
		var emptyName = false;
		
		for(i=0;i<totalCount;i++) {
			splitCodeText = splitCode[i+1].split("%");
			splitText1 = splitCodeText[0];
			for(j=0;j<totalCount;j++) {
				splitCodeText2 = splitCode[j+1].split("%");
				splitText2 = splitCodeText2[0];
				
				if (splitText1 == splitText2 && j != i) {
					equalName = true;
				}
			}
			if (splitText1 == "") {
				emptyName = true;
			}
		}
		
		
		
		if (emptyName == true) {
			alert('Profiles could NOT be saved.\nYou must have a tag name!');
			return false;
		}
		
		if (equalName == true) {
			alert('Profiles could NOT be saved.\nYou cannot have the same tag name twice!');
			return false;
		}
		else {
			return true;
		}
	}

function wpytGenerateInnerHTML(id, tagname, width, height, color, autoplay, border, relatedvideos, validxhtml, tagtype, js) {
	id=id-1;
	
	if(color == null) { color = 1; }
	
	var html = '<table class="wpyt-profile" id="innerTable'+id+'" style="width: 100%; border: 1px solid #ccc;';
	var siteURL = document.getElementById('siteURL').value;
	
	html += '">';
	html += '<tr>';
	
	html += '<td rowspan="6">';
		html += '<div id="youtube-preview'+id+'">';
			html += '<img src="'+siteURL+'/wp-content/plugins/wp-youtube/youtube-preview/';
			if (border =="y"){ html += 'border'; }
			else { html += 'color'; }
			html += color+'.gif" alt="" />';
		html += '<\/div>';
	html += '<\/td>';
	
	html += '<td>Tag name:<\/td>\n<td>Width:<\/td>\n<td>Height:<\/td>\n';
	html += '<\/tr>';
	
	html += '<tr>';
	
	html += '<td><input onkeyup="wpytOuterCodeStatic('+id+'), wpytProfileTag('+id+'), wpytProfileThemeTag('+id+');" name="tagname'+id+'" id="tagname'+id+'" type="text" style="width:90%;" value="'
	if (js!=null) { html += tagname; } else { tagname='wpyt_profile'+(id+1); html += tagname; }
	html += '" /><\/td>\n';
	
	html += '<td><input onkeyup="wpytOuterCodeStatic('+id+')" id="width'+id+'" name="width'+id+'" type="text" style="width:90%;" value="';
	if (js=='n') { html += width; } else { html += '425'; }
	html += '" /><\/td>\n';
	
	html += '<td><input onkeyup="wpytOuterCodeStatic('+id+')" id="height'+id+'" name="height'+id+'" type="text" style="width:90%;" value="';
	if (js!=null) { html += height; } else { html += '355'; }
	html += '" /><\/td>\n';
	
	html += '<td rowspan="2">';
	html += '<table>';
		html += '<tr>';
			
			html += '<td><input onclick="wpytOuterCodeStatic('+id+')" type="checkbox" name="autoplay'+id+'" id="autoplay'+id+'"';
			if (autoplay == 'y') { html += ' checked'; }
			html += '><\/td>\n';
			html += '<td style="padding-right: 20px;">Autoplay<\/td>\n';
			
			html += '<td><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',\''+color+'\',\''+border+'\');" type="checkbox" name="border'+id+'" id="border'+id+'"';
			if (border == 'y') { html += ' checked'; }
			html += '><\/td>\n';
			html += '<td style="padding-right: 20px;">Border<\/td>\n';
			
			html += '<td align="center" style="width: 50px;">[&nbsp;<input id="tagtype1_'+id+'" onclick="wpytProfileTag('+id+'), wpytOuterCodeStatic('+id+')" type="radio" name="tagtype'+id+'" value="1"';
			if (tagtype==1 || js!='n') { tagtype=1; html += ' checked="checked"'; }
			html += '>&nbsp;]<\/td>\n';
			
		html += '<\/tr><tr>';		

			html += '<td><input onclick="wpytOuterCodeStatic('+id+')" type="checkbox" name="relatedvideos'+id+'" id="relatedvideos'+id+'"';
			if (relatedvideos == 'y') { html += ' checked'; }
			html += '><\/td>\n';
			html += '<td style="padding-right: 20px;">Related videos<\/td>\n';
			
			html += '<td><input onclick="wpytOuterCodeStatic('+id+')" type="checkbox" name="validxhtml'+id+'" id="validxhtml'+id+'"';
			if (validxhtml == 'y') { html += ' checked'; }
			html += '><\/td>\n';
			html += '<td style="padding-right: 20px;">Valid&nbsp;XHTML <\/td>\n';
			
			html += '<td align="center" style="width: 50px;">&lt;&nbsp;<input id="tagtype2_'+id+'" onclick="wpytProfileTag('+id+'), wpytOuterCodeStatic('+id+')" type="radio" name="tagtype'+id+'" value="2"';
			if (tagtype==2) { html += ' checked="checked"'; }
			html += '>&nbsp;&gt;<\/td>\n';
		html += '<\/tr>';
		html += '<\/table>';
	html += '<\/td>\n';
	html += '<\/tr>';
	
	html += '<tr>';
	html += '<td colspan="3">';
	
		html += '<table style="width: 100%;">';
		html += '<tr>';
		html += '<td class="wpyt-color" style="background: #ababab;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',1,\''+border+'\');" type="radio" name="color'+id+'" value="1"';
		if (color==1 || js!='n') { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #6a6a6a;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',2,\''+border+'\');" type="radio" name="color'+id+'" value="2"';
		if (color==2) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #4b6589;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',3,\''+border+'\');" type="radio" name="color'+id+'" value="3"';
		if (color==3) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #2a89b8;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',4,\''+border+'\');" type="radio" name="color'+id+'" value="4"';
		if (color==4) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #397400;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',5,\''+border+'\');" type="radio" name="color'+id+'" value="5"';
		if (color==5) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #f08f08;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',6,\''+border+'\');" type="radio" name="color'+id+'" value="6"';
		if (color==6) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #da5078;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',7,\''+border+'\');" type="radio" name="color'+id+'" value="7"';
		if (color==7) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #6a4196;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',8,\''+border+'\');" type="radio" name="color'+id+'" value="8"';
		if (color==8) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<td class="wpyt-color" style="background: #95241a;"><input onclick="wpytOuterCodeStatic('+id+'), wpytPreview('+id+',9,\''+border+'\');" type="radio" name="color'+id+'" value="9"';
		if (color==9) { html += ' checked="checked"'; }
		html += '><\/td>\n';
		html += '<\/tr>';
		
		html += '<\/table>';
	html += '<\/td>\n';

	html += '<\/tr>';
	
	html += '<td colspan="8">';
	
	
	html += '<table style="width: 100%;">';
	html += '<tr>';
	html += '<td>';
		html += '<br />';
	
		
		html += '<div id="displayTag'+id+'">';
		var tagOutput = '';
		if (tagtype == 1) {
			tagOutput += '[' + tagname + ']';
			tagOutput += 'your_youtube_id';
			tagOutput += '[/' + tagname + ']';
			tagOutput += '<strong> (paste in posts or pages)</strong>';
		}
		else {
			tagOutput += '&lt;' + tagname + '&gt;';
			tagOutput += 'your_youtube_id';
			tagOutput += '&lt;/' + tagname + '&gt;';
			tagOutput += '<strong> (paste in posts or pages, code editor required)</strong>';
		}
		html += tagOutput;
		html += '<\/div>';
	html += '<\/td><\/tr>\n';
	
	html += '<tr>';
		html += '<td>';
			
		html += '<div id="displayThemeTag'+id+'">';
		html += '&lt;?php&nbsp;wpyoutube&nbsp;(\'' + tagname + '\',&nbsp;\'youtube_id\')'+'&nbsp;?&gt; <strong>(advanced theme use)</strong>';
		html += '<\/div>';
	html += '<\/td>\n';
	
	html += '<\/td>';
	html += '<\/tr>';
	html += '<\/table>';

	html += '<\/tr>';
	html += '<tr>';
	html += '<td colspan="8">';
	html += '<input style="width: 100%;" type="hidden" id="innerCode'+id+'" name="innerCode'+id+'" value="';
	
	html += '%t=' + tagname;
	if(js=='n') { html += '%w=' + width; } else { html += '%w='; }
	if(js=='n') {html += '%h=' + height; } else { html += '%h='; }
	
	if(js=='n' && color!="") {html += '%c=' + color; }
	if(js=='n' && autoplay!="") {html += '%a=' + autoplay; }
	if(js=='n' && validxhtml!="") {html += '%v=' + validxhtml; }
	if(js=='n' && relatedvideos!="") {html += '%r=' + relatedvideos; }
	if(js=='n' && border!="" || border=='n') {html += '%b=' + border; }
	if(js=='n' && tagtype!="") {html += '%tt=' + tagtype; }
	html += '" />';
	
	html += '<\/td>\n';
	html += '<\/tr>';
	
	html += '<tr>';
	html += '<td><input class="button delete" value="Remove profile" type="button" onclick="wpytHistoryRemove('+(id+1)+')"/><\/td>\n';
	html += '<\/table>';

	return html;
}

function wpytPreview(id, color, border) {
	
	var border = document.getElementById('border'+(id));
	
	var previewImage = document.getElementById('youtube-preview'+id);
	var siteURL = document.getElementById('siteURL').value;
	var preview;
	var color ="";
	var getColor=document.getElementsByName('color' + id);
			
	for (i=0; i<9; i++) {
		if(getColor[i].checked) { color = i+1; }
	}
				
	preview = '<img src="'+siteURL+'/wp-content/plugins/wp-youtube/youtube-preview/';
	
	if(border.checked == true){
		preview += 'border';
	}
	else {
		preview += 'color';
	}
	preview += color+'.gif" alt="" />';
	
	previewImage.innerHTML = preview;
	
}
	
/*function wpytUpdateInnerHTML(id) {
	var codeString = document.getElementById('codeString');
	var innerCode = document.getElementById('innerCode' + id);
	var width = document.getElementById('width' + id);
	var height = document.getElementById('height' + id);
	
	innerCode.value = width.value + "+" + height.value;
	codeString.value = innerCode.value;
}*/

function wpytRemoveElement(id) {
	var d = document.getElementById('myDiv');
	var olddiv = document.getElementById("my" + id + "Div");		
	d.removeChild(olddiv);
}

function wpytProfileTag(id) {
	var tagname = document.getElementById('tagname' + id).value;
	var tagtype = document.getElementById('tagtype1_' + id);
	var displayTag = document.getElementById('displayTag'+id);
	var tagOutput = '';
	
	if (tagtype.checked == true) {
		tagOutput += '[' + tagname + ']';
		tagOutput += 'your_youtube_id';
		tagOutput += '[/' + tagname + ']';
		tagOutput += '<strong> (paste in posts or pages)</strong>';
	}
	else {
		tagOutput += '&lt;' + tagname + '&gt;';
		tagOutput += 'youtube_id';
		tagOutput += '&lt;/' + tagname + '&gt;';
		tagOutput += '<strong> (paste in posts or pages, code editor required)</strong>';
	}
	displayTag.innerHTML = tagOutput;
}
function wpytProfileThemeTag(id) {
	var tagname = document.getElementById('tagname' + id).value;
	var displayThemeTag = document.getElementById('displayThemeTag'+id);
	displayThemeTag.innerHTML = '&lt;?php&nbsp;wpyoutube&nbsp;(\'' + tagname + '\',&nbsp;\'<span style="color:red;">youtube_id<\/span>\')'+'&nbsp;?&gt;';
}
function wpytInnerCodeStatic(id) {
	var innerCode = document.getElementById('innerCode' + id);
	var tagname = document.getElementById('tagname' + id).value;
	var width = document.getElementById('width' + id);
	var height = document.getElementById('height' + id);
	var autoplay = document.getElementById('autoplay' + id);
	var validxhtml = document.getElementById('validxhtml' + id);
	var relatedvideos = document.getElementById('relatedvideos' + id);
	var border = document.getElementById('border' + id);
	var color = "";
	var tagtype = "";
	
	var getColor=document.getElementsByName('color' + id);
	var getTagtype=document.getElementsByName('tagtype' + id);
	
	var innerTable = document.getElementById('innerTable' + id);
	
	for (i=0; i<9; i++) {
		if(getColor[i].checked) { color = i+1; }
	}

	for (i=0; i<2; i++) {
		if(getTagtype[i].checked) { tagtype = i+1; }
	}
	
	if (autoplay.checked == true) { autoplay = "y"; } else { autoplay = "n" }
	if (validxhtml.checked == true) { validxhtml = "y"; } else { validxhtml = "n" }
	if (relatedvideos.checked == true) { relatedvideos = "y"; } else { relatedvideos = "n" }
	if (border.checked == true) { border = "y"; } else { border = "n" }
	
	innerCode.value = "%t=" + tagname;

	innerCode.value += "%w=" + width.value;
	innerCode.value	+= "%h=" + height.value;
	
	if(color!='') { innerCode.value += "%c=" + color; }
	if(autoplay!='n') { innerCode.value += "%a=" + autoplay; }
	if(validxhtml!='n') { innerCode.value += "%v=" + validxhtml; }
	if(relatedvideos!='n') { innerCode.value += "%r=" + relatedvideos; }
	
	if(border!='n') { innerCode.value += "%b=" + border; }
	innerCode.value += "%tt=" + tagtype;
}
function wpytOuterCodeStatic(id) {
	var codeString = document.getElementById('codeString');
	var innerCode = document.getElementById('innerCode' + id);
	var history = document.getElementById('history').value;
	
	var splitHistory = new Array();
	splitHistory = history.split(",");
	
	wpytInnerCodeStatic(id);
	codeString.value = "";
	
	for(i=0; i<splitHistory.length-1;i++) {
		historyID = splitHistory[i]-1;
		if (i==splitHistory.length-1) {
			codeString.value += document.getElementById('innerCode' + historyID).value;
		}
		else {
			codeString.value += document.getElementById('innerCode' + historyID).value + ",";
		}
	}
	
}

function wpytHistoryRemove(id) {

if (confirm('Remove this profile?'))
	wpytRemoveElement(id-1);
	var codeString = document.getElementById('codeString');
	
	codeString.value = "";
	
	var innerCode;
	var history = document.getElementById('history');
	history.value = history.value.replace((id)+",","");
	
	teststring = history.value.split(",");
	for(i=0;i<teststring.length-1;i++) {
		codeString.value += document.getElementById('innerCode' + (teststring[i]-1)).value + ",";
		
	}
	
	if (history.value == "") {
		var removeAllButton = document.getElementById('removeAllButton');
		removeAllButton.style.display = "none";
		
		var introText = document.getElementById('introText');
		introText.style.display = "block";
	}
	
}
function wpytHistoryOutput(id) {
	var history = document.getElementById('history');
	history.value += id + ",";
}

function wpytRemoveAll() {

	if ( confirm("Remove all profiles? (is not saved until options is updated)")){
		var history = document.getElementById('history');
		var codeString = document.getElementById('codeString');
		var splitHistory = new Array();
		splitHistory = history.value.split(",");
		
		for(i=0; i<splitHistory.length-1;i++) {
			historyID = splitHistory[i]-1;
			wpytRemoveElement(historyID);
		}
		history.value = "";
		codeString.value = "";
		
			var removeAllButton = document.getElementById('removeAllButton');
			removeAllButton.style.display = "none";
			
			var introText = document.getElementById('introText');
			introText.style.display = "block";
		
	}
}

function wpytAddElement() {

	var introText = document.getElementById('introText');
	introText.style.display = "none";

	var removeAllButton = document.getElementById('removeAllButton');
	removeAllButton.style.display = "block";

	var ni = document.getElementById('myDiv');

	var numi = document.getElementById('theValue');
	var num = (document.getElementById('theValue').value -1)+ 2;

	var length = document.getElementById('length').value;

	numi.value = num;
	num = parseInt(num) + parseInt(length);

	wpytHistoryOutput(num);


	var newdiv = document.createElement('div');
	var divIdName = 'my'+(num-1)+'Div';

	newdiv.setAttribute('id',divIdName);
	newdiv.innerHTML = wpytGenerateInnerHTML(num);
	ni.appendChild(newdiv);

	var firstDiv = document.getElementsByTagName('div');

	var divPosition;

	for(i=0;i<firstDiv.length;i++) {
		if (firstDiv[i].id == "myDiv") {
			divPosition = i+1;
		}
	}

	var reverseOrder = document.getElementsByTagName('div')[divPosition];
	reverseOrder.parentNode.insertBefore(newdiv,reverseOrder);

	wpytOuterCodeStatic(num-1);
}