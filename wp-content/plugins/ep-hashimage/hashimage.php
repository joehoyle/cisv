<?php
/*
Plugin Name: EP Hashimage
Plugin URI: http://darkwhispering.com/wordpress-plugins
Description: Display image by hashtag from twitter or instagram in your template, post/page or widget area using template tag, shortcode or the widget.
Author: Mattias Hedman & Peder Fjällström
Version: 4.0.1
Author URI: http://darkwhispering.com
*/

define('HASHIMAGE_VERSION', '4.0.1');

if (!$_GET['asyncload']) {
    function plugin_init() {
        // Set default values
        add_option('ep_hashimage_async','true');                // For faster loading
        add_option('ep_hashimage_img_display','lightbox');      // Display method of retrived images
        add_option('ep_hashimage_refresh','false');             // Auto reload search every 15 min
        add_option('ep_hashimage_network','twitter');           // Network to search in twitter/instagram
        add_option('ep_hashimage_instagram_client_id',NULL);    // Instagram api client_id

        // Default image sizes
        $default_img_sizes = array(
            'thumb_h'           => 200,
            'thumb_w'           => 200,
            'widget_thumb_h'    => 80,
            'widget_thumb_w'    => 80,
            'lightbox_h'        => 400,
            'lightbox_w'        => 600
        );
        add_option('ep_hashimage_img_sizes',$dedault_img_sizes);  

        // Default twitter search networks
        $default_networks = array(
            'instagram' => 'instagr.am',
            'twitpic'   => 'twitpic',
            'twitter'   => 'pic.twitter.com',
            'yfrog'     => 'yfrog',
            'flickr'    => 'flic.kr',
            'plixi'     => 'plixi'
        );
        add_option('ep_hashimage_networks',$default_networks);

        // Plugin version
        update_option('ep_hashimage_plugin_version',HASHIMAGE_VERSION);
    }
    add_action('init','plugin_init',10);
}

class Hashimage {

    function __construct($args = array())
    {
        // Setup settings array
        $default_settings = array(
            'hashtag'               => 'unicorn',
            'limit'                 => '5',
            'type'                  => 'plugin',
            'output'                => 'html',
            'network'               => get_option('ep_hashimage_network'),
            'networks'              => get_option('ep_hashimage_networks'),
            'async'                 => get_option('ep_hashimage_async'),
            'img_display'           => get_option('ep_hashimage_img_display'),
            'refresh'               => get_option('ep_hashimage_refresh'),
            'img_sizes'             => get_option('ep_hashimage_img_sizes'),
            'instagram_client_id'   => get_option('ep_hashimage_instagram_client_id')
        );

        // Merge default settings with the new arguments from the user
        $this->settings = wp_parse_args($args, $default_settings);

        // Twitter Search URL
        $this->twitterUrl = 'http://search.twitter.com/search.json?q=&phrase=&ors=';
        
        // Check what networks within twitter we should use and add to the url
        $this->twitterUrl .= implode('+',$this->settings['networks']);

        // Add the hashtag 
        $this->twitterUrl .= '&lang=all&include_entities=true&rpp=500&tag='.str_replace('#','',$this->settings['hashtag']);

        // Instagram API with hashtag and client_id
        $this->instagramUrl = 'https://api.instagram.com/v1/tags/'.str_replace('#','',$this->settings['hashtag']).'/media/recent?client_id='.$this->settings['instagram_client_id'];

        // Do the magic
        $this->_init();
    }

    /**
    * The heart of the plugin, here we do the heavy loading
    **/
    private function _init()
    {
        $twitterjson    = '';
        $instagramjson  = '';
        $image          = array();

        // Check if we should load this asynct or not
        if (isset($_GET['asyncload']) || $this->settings['async'] === 'false')
        {
            if ($this->settings['network']['twitter'])
            {
                $twitterjson = json_decode($this->_fetchurl($this->twitterUrl, 600+rand(1,120)));
            }
            if ($this->settings['network']['instagram'])
            {
                $instagramjson = json_decode($this->_fetchurl($this->instagramUrl, 600+rand(1,120)));
            }
        }

        // Process the result from twitter
        if (isset($twitterjson) && $twitterjson->results) {
            foreach ($twitterjson->results as $results) {

                // If it is links to other networks
                if (isset($results->entities) && isset($results->entities->urls)) {
                    foreach ($results->entities->urls as $url) {
                        if (!empty($url->expanded_url) && !empty($url->url)) {
                            $links[md5($url->expanded_url)]['img']      = $url->expanded_url;
                            $links[md5($url->expanded_url)]['source']   = $url->url;
                        }
                    }
                }

                // If it is twitter media
                if (isset($results->entities) && isset($results->entities->media)) {
                    foreach ($results->entities->media as $image) {
                        if (!empty($image->media_url) && !empty($image->url)) {
                            $images[md5($image->media_url)]['img']      = $image->media_url;
                            $images[md5($image->media_url)]['source']   = $image->url;
                        }
                    }
                }
            }

            // Get the images from the links on twitter
            if ($links && $images) {
                $images = array_merge($this->_extractimages($links),$images);
            } else if (!$images) {
                $image = $links;
            }
        }

        // Process the results from instagram
        if (isset($instagramjson) && isset($instagramjson->data)) {
            foreach ($instagramjson->data as $result) {
                if (!empty($result->link) && !empty($result->images->standard_resolution->url)) {
                    $images[md5($result->images->standard_resolution->url)]['img']      = $result->images->standard_resolution->url;
                    $images[md5($result->images->standard_resolution->url)]['source']   = $result->link;
                }
            }
        }
        
        if ($images) {
            // Remove any doubles
            $images = array_map('unserialize', array_unique(array_map('serialize', $images)));

            // Remove images without img url or source url
            foreach ($images as $key => $image) {
                if(empty($image['img']) || empty($image['source'])) {
                    unset($images[$key]);
                }
            }

            // If both twitter and instagram is used, lets shuffel the results
            if ($this->settings['network']['twitter'] && $this->settings['network']['instagram']) {
                shuffle($images);
            }

            // Limit the amount of images returned to the output after the limit
            $images = array_slice($images, 0, $this->settings['limit']);
        }

        // Build the output
        if ($this->settings['output'] === 'html') {
            $this->output = $this->_formathtml($images);
        } elseif ($this->settings['output'] === 'array') {
            $this->output = $images;
        }
    }

    /**
    * Fetch the url
    **/
    private function _fetchurl($url = null, $ttl = 86400){
        if ($url) {
            $option_name = 'hashimage_cache_'.md5($url);

            // Chec if cache of the urls allready exists, if not, get content of the url
            if (false === ($data = get_site_transient($option_name))) {
                $ch = curl_init();
                $options = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_TIMEOUT => 10
                );
                curl_setopt_array($ch, $options);
                $data['chunk'] = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if($http_code === 200){
                    // Set the new cache
                    set_site_transient($option_name, $data, $ttl);
                }
            }

            return $data['chunk'];
        }
    }

    /**
    * Extract the images from the data returned
    **/
    private function _extractimages($links){
        if($links){
            foreach($links as $link){
                // yfrog.com
                if (stristr($link['img'],'yfrog.com'))
                {
                    $images[md5($link['img'])]['img']       = $this->_extractyfrog($link['img']);
                    $images[md5($link['img'])]['source']    = $link['source'];
                }
                // plixi.com
                else if (stristr($link['img'],'plixi.com'))
                {
                    $images[md5($link['img'])]['img']       = $this->_extractplixi($link['img']);
                    $images[md5($link['img'])]['source']    = $link['source'];
                }
                // instagr.am
                else if (stristr($link['img'],'instagr.am'))
                {
                    $images[md5($link['img'])]['img']       = $this->_extractinstagram($link['img']);
                    $images[md5($link['img'])]['source']    = $link['source'];
                }
                // twitpic.com
                else if (stristr($link['img'],'twitpic.com'))
                {
                    $images[md5($link['img'])]['img']       = $this->_extracttwitpic($link['img']);
                    $images[md5($link['img'])]['source']    = $link['source'];
                }
                // flic.kr
                else if (stristr($link['img'],'flic.kr'))
                {
                    $images[md5($link['img'])]['img']       = $this->_extractflickr($link['img']);
                    $images[md5($link['img'])]['source']    = $link['source'];
                }
            }

            return $images;
        }
    }

    /**
    * Extract yfrog images
    **/
    private function _extractyfrog($link){
        return trim($link,'”."').':iphone';
    }

    /**
    * Extract twitpic images
    **/
    private function _extracttwitpic($link){
        $linkparts = explode('/',$link);
        return 'http://twitpic.com/show/large/'.$linkparts[3];
    }

    /**
    * Extract flickr images
    **/
    private function _extractflickr($link){
        $string = $this->_fetchurl($link);
        if(isset($string)){
            preg_match_all('!<img src="(.*?)" alt="photo" !', $string, $matches);
            if(isset($matches[1][0])){
                return $matches[1][0];
            }
        }
    }

    /**
    * Extract instagram images
    **/
    private function _extractinstagram($link){
        $link = trim($link);

        $search = 'instagr.am';
        $replace = 'instagram.com';

        $link = str_replace($search, $replace, $link);

        $string = $this->_fetchurl($link);
        if(isset($string)){
            preg_match_all('! class="photo" src="(.*?)" !', $string, $matches);
            if(isset($matches[1][0]) && !empty($matches[1][0])){
                return $matches[1][0];
            }
        }
    }

    /**
    * Extract plixi images
    **/
    private function _extractplixi($link){
        $string = $this->_fetchurl($link);
        if(isset($string)){
            preg_match_all('! src="(.*)" id="photo"!', $string, $matches);
            if($matches[1][0]){
                return $matches[1][0];
            }
        }
    }

    /**
    * Build the HTML code
    **/
    private function _formathtml($images = array())
    {
        $html = '';

        // Arguments for the async loding
        $jsargs = array(
            'pluginpath'    => plugins_url('hashimage.php',__FILE__),
            'hashtag'       => $this->settings['hashtag'],
            'limit'         => $this->settings['limit'],
            'type'          => $this->settings['type'],
            'async'         => $this->settings['async'],
            'refresh'       => $this->settings['refresh']
        );

        // If async is true, add the async arguments as json in a data attribute and display a loading img and text.        
        if ($this->settings['async'] === 'true' && $_GET['asyncload'] != 'true')
        {
            $html .= "<ul class='hashimage-container' data-options='".json_encode($jsargs)."'>";
            $html .= '<p class="hashimage-loading"><img src="'.plugins_url('loading.gif',__FILE__).'" alt="Loading"> Loading hashimages...</p>';
        }
        // If async is false or this is the actual async request, build the html
        else
        {
            $html .= "<ul class='hashimage-container' data-options='".json_encode($jsargs)."'>";
            $html .= '<p class="hashimage-loading" style="sidplay:none;"><img src="'.plugins_url('loading.gif',__FILE__).'" alt="Loading"> Loading hashimages...</p>';
            if (!empty($images)) {
                foreach ($images as $image) {
                    $html .= '<li>';

                    // If image display method is lightbox
                    if ($this->settings['img_display'] === 'lightbox')
                    {
                        // If widget
                        if ($this->settings['type'] == 'widget' || $_GET['type'] == 'widget')
                        {
                            $html .= '<a href="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['lightbox_w'].'&amp;h='.$this->settings['img_sizes']['lightbox_h'].'&amp;zc=2" rel="lightbox-'.$this->settings['hashtag'].'"><img src="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['widget_thumb_w'].'&amp;h='.$this->settings['img_sizes']['widget_thumb_h'].'" alt="Image loaded with Hashimage" /></a>'."\n";
                        }
                        // If not widget
                        else
                        {
                            $html .= '<a href="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['lightbox_w'].'&amp;h='.$this->settings['img_sizes']['lightbox_h'].'&amp;zc=2" rel="lightbox-'.$this->settings['hashtag'].'"><img src="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['thumb_w'].'&amp;h='.$this->settings['img_sizes']['thumb_h'].'" alt="Image loaded with Hashimage" /></a>'."\n";
                        }
                    }
                    // If image display method is original source
                    elseif($this->settings['img_display'] === 'source')
                    {
                        // If widget
                        if ($this->settings['type'] == 'widget' || $_GET['type'] == 'widget')
                        {
                            $html .= '<a href="'.$image['source'].'" target="_blank"><img src="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['widget_thumb_w'].'&amp;h='.$this->settings['img_sizes']['widget_thumb_h'].'" alt="Image loaded with Hashimage" /></a>'."\n";
                        }
                        // If not widget
                        else
                        {
                            $html .= '<a href="'.$image['source'].'" target="_blank"><img src="'.plugins_url('timthumb.php',__FILE__).'?src='.$image['img'].'&amp;w='.$this->settings['img_sizes']['thumb_w'].'&amp;h='.$this->settings['img_sizes']['thumb_h'].'" alt="Image loaded with Hashimage" /></a>'."\n";
                        }
                    }
                    $html .= '</li>';
                }  
            } else {
                $html .= '<li>No images found for your hashtag!</li>';
            }
        }
        $html .= '</ul>';

        return $html;
    }
}

function hashimage($args = array()){
    $hashimage = new Hashimage($args);
    return $hashimage->output;
}

/**
* IF THIS IS AN ASYNC REQUEST
**/
if(!defined('ABSPATH')){
    require("../../../wp-load.php");
    $args = array (
        'hashtag'   => strip_tags($_GET['hashtag']),
        'limit'     => (int)$_GET['limit'],
        'type'      => $_GET['type']
    );
    echo hashimage($args); 
    exit(0);
}

// Include widget
include_once('widget.php');

// Include shortcode
include_once('shortcode.php');

// Include settings page
include_once('settings-page.php');

//Frontpage JS and CSS
function hashimage_js() {
    wp_enqueue_script("jquery");
    wp_register_script('hashimage_js', plugins_url('js/slimbox2.js', __FILE__));
    wp_register_script('hashimage_js_async', plugins_url('js/async.js', __FILE__));
    wp_enqueue_script('hashimage_js');
    wp_enqueue_script('hashimage_js_async');
}
add_action('wp_print_scripts','hashimage_js');

function hashimage_css() {
    wp_register_style('hashimage_slimbox_css', plugins_url('css/slimbox2.css', __FILE__));
    wp_register_style('hashimage_css', plugins_url('css/style.css', __FILE__));
    wp_enqueue_style('hashimage_slimbox_css');
    wp_enqueue_style('hashimage_css');
}
add_action('wp_print_styles','hashimage_css');

// IF the plugin is beeing deactivated
function hashimage_deactivate() {
    global $wpdb;
    $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s", '%hashimage_cache%'));

    $wp_upload_dir = wp_upload_dir();
    $cachdir = $wp_upload_dir['basedir'].'/ep_hashimage/';
    foreach(glob($cachdir . '/*') as $file) { 
        if(is_dir($file)) rrmdir($file); else unlink($file);
    }
    rmdir($cachdir);
}
register_deactivation_hook( __FILE__, 'hashimage_deactivate' );