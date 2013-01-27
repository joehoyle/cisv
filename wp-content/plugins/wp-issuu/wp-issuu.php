<?php
/*
    Plugin Name: WP Issuu
    Description: Embed Issuu publications inside a post
    Version: 2.15
    Author: Issuu
*/

/*
    Copyright 2011  ISSUU  (email : feedback@issuu.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function issuu_parser($content)
{
    $content = preg_replace_callback('/\[issuu ([^]]*)\]/i', 'issuu_switcher', $content);
    return $content;
}

function getValueWithDefault($regex, $params, $default)
{
    $matchCount = preg_match_all($regex, $params, $matches);
    if ($matchCount) {
        return $matches[1][0];
    } else {
        return $default;
    }
}

function issuu_switcher($matches)
{
    $v = getValueWithDefault('/(?:^|[\s]+)v=([\S]*)/i', $matches[1], 1);
    switch ($v) {
    case 1:
        return issuu_reader_1($matches);
    case 2:
        return issuu_reader_2($matches);
    default:
        return $matches;
    }
}

function issuu_reader_1($matches)
{
    $folderId = getValueWithDefault('/(?:^|[\s]+)folderId=([\S]*)/i', $matches[1], '');
    $documentId = getValueWithDefault('/(?:^|[\s]+)documentId=([\S]*)/i', $matches[1], '');
    $username = getValueWithDefault('/(?:^|[\s]+)username=([\S]*)/i', $matches[1], '');
    $docName = getValueWithDefault('/(?:^|[\s]+)docName=([\S]*)/i', $matches[1], '');
    $loadingInfoText = getValueWithDefault('/(?:^|[\s]+)loadingInfoText=([\S]*)/i', $matches[1], '');
    $tag = getValueWithDefault('/(?:^|[\s]+)tag=([\S]*)/i', $matches[1], '');
    $showFlipBtn = getValueWithDefault('/(?:^|[\s]+)showFlipBtn=([\S]*)/i', $matches[1], 'false');
    $proShowMenu = getValueWithDefault('/(?:^|[\s]+)proShowMenu=([\S]*)/i', $matches[1], 'false');
    $proShowSidebar = getValueWithDefault('/(?:^|[\s]+)proShowSidebar=([\S]*)/i', $matches[1], 'false');
    $autoFlip = getValueWithDefault('/(?:^|[\s]+)autoFlip=([\S]*)/i', $matches[1], 'false');
    $autoFlipTime = getValueWithDefault('/(?:^|[\s]+)autoFlipTime=([\S]*)/i', $matches[1], 6000);
    $backgroundColor = getValueWithDefault('/(?:^|[\s]+)backgroundColor=([\S]*)/i', $matches[1], '');
    $layout = getValueWithDefault('/(?:^|[\s]+)layout=([\S]*)/i', $matches[1], '');
    $height = getValueWithDefault('/(?:^|[\s]+)height=([\S]*)/i', $matches[1], 301);
    $width = getValueWithDefault('/(?:^|[\s]+)width=([\S]*)/i', $matches[1], 450);
    $unit = 'px';//getValueWithDefault('/(?:^|[\s]+)unit=([\S]*)/i', $params, 'px');
    $viewMode = getValueWithDefault('/(?:^|[\s]+)viewMode=([\S]*)/i', $matches[1], '');
    $pageNumber = getValueWithDefault('/(?:^|[\s]+)pageNumber=([\S]*)/i', $matches[1], 1);
    $logo = getValueWithDefault('/(?:^|[\s]+)logo=([\S]*)/i', $matches[1], '');
    $logoOffsetX = getValueWithDefault('/(?:^|[\s]+)logoOffsetX=([\S]*)/i', $matches[1], 0);
    $logoOffsetY = getValueWithDefault('/(?:^|[\s]+)logoOffsetY=([\S]*)/i', $matches[1], 0);
    $showHtmlLink = getValueWithDefault('/(?:^|[\s]+)showHtmlLink=([\S]*)/i', $matches[1], 'false');

    $domain = 'issuu.com';

    $viewerUrl = 'http://static.' . $domain . '/webembed/viewers/style1/v1/IssuuViewer.swf';
    $standaloneUrl = 'http://' . $domain . '/' . $username . '/docs/' . $docName . '?mode=embed';
    $moreUrl = 'http://' . $domain . '/search?q=' . $tag;

    $flashVars = 'mode=embed';

    if ($folderId) {
        // load folder parameters
        $flashVars = $flashVars . '&amp;folderId=' . $folderId;
    } else {
        // load document parameters
        if ($documentId) {
            $flashVars = $flashVars . '&amp;documentId=' . $documentId;
        }
        if ($docName) {
            $flashVars = $flashVars . '&amp;docName=' . $docName;
        }
        if ($username) {
            $flashVars = $flashVars . '&amp;username=' . $username;
        }
        if ($loadingInfoText) {
            $flashVars = $flashVars . '&amp;loadingInfoText=' . $loadingInfoText;
        }
    }
    if ($showFlipBtn == 'true') {
        $flashVars = $flashVars . '&amp;showFlipBtn=' . $showFlipBtn;
    }
    if ($proShowMenu == 'true') {
        $flashVars = $flashVars . '&amp;proShowMenu=' . $proShowMenu;
    }
    if ($proShowSidebar == 'true') {
        $flashVars = $flashVars . '&amp;proShowSidebar=' . $proShowSidebar;
    }
    if ($autoFlip == 'true') {
        $flashVars = $flashVars . '&amp;autoFlip=' . $autoFlip;
        if ($autoFlipTime) {
            $flashVars = $flashVars . '&amp;autoFlipTime=' . $autoFlipTime;
        }
    }
    if ($backgroundColor) {
        $flashVars = $flashVars . '&amp;backgroundColor=' . $backgroundColor;
        $standaloneUrl = $standaloneUrl . '&amp;backgroundColor=' . $backgroundColor;
    }
    if ($layout) {
        $flashVars = $flashVars . '&amp;layout=' . $layout;
        $standaloneUrl = $standaloneUrl . '&amp;layout=' . $layout;
    }
    if ($viewMode) {
        $flashVars = $flashVars . '&amp;viewMode=' . $viewMode;
        $standaloneUrl = $standaloneUrl . '&amp;viewMode=' . $viewMode;
    }
    if ($pageNumber > 1) {
        $flashVars = $flashVars . '&amp;pageNumber=' . $pageNumber;
        $standaloneUrl = $standaloneUrl . '&amp;pageNumber=' . $pageNumber;
    }
    if ($logo) {
        $flashVars = $flashVars . '&amp;logo=' . $logo . '&amp;logoOffsetX=' . $logoOffsetX . '&amp;logoOffsetY=' . $logoOffsetY;
        $standaloneUrl = $standaloneUrl . '&amp;logo=' . $logo . '&amp;logoOffsetX=' . $logoOffsetX . '&amp;logoOffsetY=' . $logoOffsetY;
    }

    return ( ($showHtmlLink == 'true') ? '<div>' : '') . 
           '<object style="width:' . $width . $unit . ';height:' . $height . $unit. '" ><param name="movie" value="' . $viewerUrl . '?' . $flashVars . '" />' . 
           '<param name="allowfullscreen" value="true"/><param name="menu" value="false"/>' . 
           '<embed src="' . $viewerUrl . '" type="application/x-shockwave-flash" style="width:' . $width . $unit . ';height:' . $height . $unit . '" flashvars="' .
           $flashVars . '" allowfullscreen="true" menu="false" /></object>' . 
           ( ($showHtmlLink == 'true') ? ( '<div style="width:' . $width . $unit . ';text-align:left;">' . 
           ( $folderId ? '' : ('<a href="' . $standaloneUrl . '" target="_blank">Open publication</a> - ') ) . 
           'Free <a href="http://issuu.com" target="_blank">publishing</a>' . 
           ( $folderId ? '' : ( $tag ? (' - <a href="' . $moreUrl. '" target="_blank">More ' . urldecode($tag) . '</a>') : '' ) ) . '</div></div>' ) : '');
}

function issuu_reader_2($matches)
{
    $viewMode = getValueWithDefault('/(?:^|[\s]+)viewMode=([\S]*)/i', $matches[1], 'doublePage');
    $autoFlip = getValueWithDefault('/(?:^|[\s]+)autoFlip=([\S]*)/i', $matches[1], 'false');
    $width = getValueWithDefault('/(?:^|[\s]+)width=([\S]*)/i', $matches[1], 420);
    $height = getValueWithDefault('/(?:^|[\s]+)height=([\S]*)/i', $matches[1], 300);
    $unit = getValueWithDefault('/(?:^|[\s]+)unit=([\S]*)/i', $matches[1], 'px');
    $embedBackground = getValueWithDefault('/(?:^|[\s]+)embedBackground=([\S]*)/i', $matches[1], '');
    $pageNumber = getValueWithDefault('/(?:^|[\s]+)pageNumber=([\S]*)/i', $matches[1], 1);
    $titleBarEnabled = getValueWithDefault('/(?:^|[\s]+)titleBarEnabled=([\S]*)/i', $matches[1], 'false');
    $shareMenuEnabled = getValueWithDefault('/(?:^|[\s]+)shareMenuEnabled=([\S]*)/i', $matches[1], 'true');
    $showHtmlLink = getValueWithDefault('/(?:^|[\s]+)showHtmlLink=([\S]*)/i', $matches[1], 'true');
    $proSidebarEnabled = getValueWithDefault('/(?:^|[\s]+)proSidebarEnabled=([\S]*)/i', $matches[1], 'false');
    // Renamed proShowSidebar to proSidebarEnabled (Feb. 2011)
    if ($proSidebarEnabled == 'false') { // Backward compatible
        $proSidebarEnabled = getValueWithDefault('/(?:^|[\s]+)proShowSidebar=([\S]*)/i', $matches[1], 'false');
    }
    $printButtonEnabled = getValueWithDefault('/(?:^|[\s]+)printButtonEnabled=([\S]*)/i', $matches[1], 'true');
    $shareButtonEnabled = getValueWithDefault('/(?:^|[\s]+)shareButtonEnabled=([\S]*)/i', $matches[1], 'true');
    $searchButtonEnabled = getValueWithDefault('/(?:^|[\s]+)searchButtonEnabled=([\S]*)/i', $matches[1], 'true');
    $linkTarget = getValueWithDefault('/(?:^|[\s]+)linkTarget=([\S]*)/i', $matches[1], '_blank');
    $backgroundColor = getValueWithDefault('/(?:^|[\s]+)backgroundColor=([\S]*)/i', $matches[1], '');
    $theme = getValueWithDefault('/(?:^|[\s]+)theme=([\S]*)/i', $matches[1], 'default');
    $backgroundImage = getValueWithDefault('/(?:^|[\s]+)backgroundImage=([\S]*)/i', $matches[1], '');
    $backgroundStretch = getValueWithDefault('/(?:^|[\s]+)backgroundStretch=([\S]*)/i', $matches[1], 'false');
    $backgroundTile = getValueWithDefault('/(?:^|[\s]+)backgroundTile=([\S]*)/i', $matches[1], 'false');
    $layout = getValueWithDefault('/(?:^|[\s]+)layout=([\S]*)/i', $matches[1], '');
    $logo = getValueWithDefault('/(?:^|[\s]+)logo=([\S]*)/i', $matches[1], '');
    $documentId = getValueWithDefault('/(?:^|[\s]+)documentId=([\S]*)/i', $matches[1], '');
    $folderId = getValueWithDefault('/(?:^|[\s]+)folderId=([\S]*)/i', $matches[1], '');
    $name = getValueWithDefault('/(?:^|[\s]+)name=([\S]*)/i', $matches[1], '');
    $username = getValueWithDefault('/(?:^|[\s]+)username=([\S]*)/i', $matches[1], '');
    $tag = getValueWithDefault('/(?:^|[\s]+)tag=([\S]*)/i', $matches[1], '');
    $scriptAccessEnabled = getValueWithDefault('/(?:^|[\s]+)scriptAccessEnabled=([\S]*)/i', $matches[1], 'false');
    $id = getValueWithDefault('/(?:^|[\s]+)id=([\S]*)/i', $matches[1], '');

    $domain = 'issuu.com';

    $readerUrl = 'http://static.' . $domain . '/webembed/viewers/style1/v2/IssuuReader.swf';
    $openUrl = 'http://' . $domain . '/' . $username . '/docs/' . $name . '?mode=window';
    $moreUrl = 'http://' . $domain . '/search?q=' . $tag;

    $flashVars = 'mode=mini';
    // ****** embed options ******
    // layout
    if ($viewMode == 'doublePage') { // default value
    } else {
        $flashVars = $flashVars . '&amp;viewMode=' . $viewMode;
    }
    if ($autoFlip == 'false') { // default value
    } else {
        $flashVars = $flashVars . '&amp;autoFlip=' . $autoFlip;
    }
    // color
    if ($embedBackground) {
        $flashVars = $flashVars . '&amp;embedBackground=' . $embedBackground;
    }
    // start on
    if ($pageNumber == 1) { // default value
    } else {
        $flashVars = $flashVars . '&amp;pageNumber=' . $pageNumber;
    }
    // show
    if ($titleBarEnabled == 'false') { // default value
    } else {
        $flashVars = $flashVars . '&amp;titleBarEnabled=' . $titleBarEnabled;
    }
    if ($shareMenuEnabled == 'true') { // default value
    } else {
        $flashVars = $flashVars . '&amp;shareMenuEnabled=' . $shareMenuEnabled;
    }
    if ($proSidebarEnabled == 'false') { // default value
    } else {
        $flashVars = $flashVars . '&amp;proSidebarEnabled=' . $proSidebarEnabled;
    }
    // ****** fullscreen options ******
    // show
    if ($printButtonEnabled == 'true') { // default value
    } else {
        $flashVars = $flashVars . '&amp;printButtonEnabled=' . $printButtonEnabled;
    }
    if ($shareButtonEnabled == 'true') { // default value
    } else {
        $flashVars = $flashVars . '&amp;shareButtonEnabled=' . $shareButtonEnabled;
    }
    if ($searchButtonEnabled == 'true') { // default value
    } else {
        $flashVars = $flashVars . '&amp;searchButtonEnabled=' . $searchButtonEnabled;
    }
    // links
    if ($linkTarget == '_blank') { // default value
    } else {
        $flashVars = $flashVars . '&amp;linkTarget=' . $linkTarget;
    }
    // design
    if ($backgroundColor) {
        $flashVars = $flashVars . '&amp;backgroundColor=' . $backgroundColor;
    }
    if ($theme == 'default') { // default value
    } else {
        $flashVars = $flashVars . '&amp;theme=' . $theme;
    }
    if ($backgroundImage) {
        $flashVars = $flashVars . '&amp;backgroundImage=' . $backgroundImage;
    }
    if ($backgroundStretch == 'false') { // default value
    } else {
        $flashVars = $flashVars . '&amp;backgroundStretch=' . $backgroundStretch;
    }
    if ($backgroundTile == 'false') { // default value
    } else {
        $flashVars = $flashVars . '&amp;backgroundTile=' . $backgroundTile;
    }
    if ($layout) {
        $flashVars = $flashVars . '&amp;layout=' . $layout;
    }
    if ($logo) {
        $flashVars = $flashVars . '&amp;logo=' . $logo;
    }
    // ****** document information ******
    if ($documentId) {
        $flashVars = $flashVars . '&amp;documentId=' . $documentId;
    } else if ($folderId) {
        $flashVars = $flashVars . '&amp;folderId=' . $folderId;
    }

    return ( ($showHtmlLink == 'true') ? '<div>' : '' ) . 
           '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:' . $width . $unit . ';height:' . $height . $unit. '" ' . 
           ( ($id) ? ('id="' . $id . '" ') : '' ) . '><param name="movie" value="' . $readerUrl . '?' . $flashVars . '" />' . 
           '<param name="allowfullscreen" value="true"/>' . 
           ( ($linkTarget == '_blank' && $scriptAccessEnabled == 'false') ? '' : '<param name="allowscriptaccess" value="always"/>' ) . 
           '<param name="menu" value="false"/><param name="wmode" value="transparent"/>' . 
           '<embed src="' . $readerUrl . '" type="application/x-shockwave-flash" style="width:' . $width . $unit . ';height:' . $height . $unit . '" flashvars="' .
           $flashVars . '" allowfullscreen="true" ' . 
           ( ($linkTarget == '_blank' && $scriptAccessEnabled == 'false') ? '' : 'allowscriptaccess="always" ' ) . 
           'menu="false" wmode="transparent" /></object>' . 
           ( ($showHtmlLink == 'true') ? ( '<div style="width:' . $width . $unit . ';text-align:left;">' . 
           '<a href="' . $openUrl . '" target="_blank">Open publication</a> - ' . 
           'Free <a href="http://' . $domain . '" target="_blank">publishing</a>' . 
           ( $tag ? (' - <a href="' . $moreUrl. '" target="_blank">More ' . urldecode($tag) . '</a>') : '' ) . '</div></div>' ) : '');
}

add_filter('the_content', 'issuu_parser');

?>