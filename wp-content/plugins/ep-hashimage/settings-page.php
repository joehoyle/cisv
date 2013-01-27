<?php

class epHashimageSettings {
    function hashimage_panel() {
        if (!current_user_can('manage_options'))  {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }

        // Setup settings array
        $settings = array(
            'network'               => get_option('ep_hashimage_network'),
            'networks'              => get_option('ep_hashimage_networks'),
            'async'                 => get_option('ep_hashimage_async'),
            'img_display'           => get_option('ep_hashimage_img_display'),
            'refresh'               => get_option('ep_hashimage_refresh'),
            'img_sizes'             => get_option('ep_hashimage_img_sizes'),
            'instagram_client_id'   => get_option('ep_hashimage_instagram_client_id')
        );
    ?>
        <div class="wrap ep-hashimage">
            <div class="icon32" id="icon-options-general"><br></div>
            <h2>EP Hashimage settings</h2>

            <?php
                if ($_POST['clear_cache']) {
                    global $wpdb;
                    if($wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s", '%hashimage_cache%'))) {
                        echo '<div class="updated"><p><strong>Cache cleared</strong></p></div>';
                    }
                }
            ?>
                       
            <form method="post" action="options.php">
                <?php wp_nonce_field('update-options'); ?>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                Dimension for thumbnails
                            </th>
                            <td>
                                <input type="number" name="ep_hashimage_img_sizes[thumb_w]" class="small-text" value="<?php echo $settings['img_sizes']['thumb_w']; ?>" /> x <input type="number" name="ep_hashimage_img_sizes[thumb_h]" class="small-text" value="<?php echo $settings['img_sizes']['thumb_h']; ?>" />px 
                                <p class="description">(W x H - Default values is 200x200)</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Dimension for widget thumbnails
                            </th>
                            <td>
                                 <input type="number" name="ep_hashimage_img_sizes[widget_thumb_w]" class="small-text" value="<?php echo $settings['img_sizes']['widget_thumb_w']; ?>" /> x <input type="number" name="ep_hashimage_img_sizes[widget_thumb_h]" class="small-text" value="<?php echo $settings['img_sizes']['widget_thumb_h']; ?>" />px
                                 <p class="description">(W x H - Default values is 80x80)</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Dimension for lightbox
                            </th>
                            <td>
                                <input type="number" name="ep_hashimage_img_sizes[lightbox_w]" class="small-text" value="<?php echo $settings['img_sizes']['lightbox_w']; ?>" /> x <input type="number" name="ep_hashimage_img_sizes[lightbox_h]" class="small-text" value="<?php echo $settings['img_sizes']['lightbox_h']; ?>" />px
                                <p class="description">(W x H - Default values is 600x400)</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Async
                            </th>
                            <td>
                                <input type="radio" name="ep_hashimage_async" value="true" <?php if($settings['async'] === 'true') echo 'checked="checked"'; ?> /> true
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="ep_hashimage_async" value="false" <?php if($settings['async'] === 'false') echo 'checked="checked"'; ?> /> false
                                <p class="description">(Quicker page loads. Recommended!)</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Auto refresh
                            </th>
                            <td>
                                <input type="radio" name="ep_hashimage_refresh" value="true" <?php if($settings['refresh'] === 'true') echo 'checked="checked"'; ?> /> true
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="ep_hashimage_refresh" value="false" <?php if($settings['refresh'] === 'false') echo 'checked="checked"'; ?> /> false
                                <p class="description">Refresh every 15 min</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                How to open images on click
                            </th>
                            <td>
                                <input type="radio" name="ep_hashimage_img_display" value="lightbox" <?php if($settings['img_display'] === 'lightbox') echo 'checked="checked"'; ?> /> Lightbox
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="ep_hashimage_img_display" value="source" <?php if($settings['img_display'] === 'source') echo 'checked="checked"'; ?> /> Original source</p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Choose network
                            </th>
                            <td>
                                <?php
                                    if ($settings['network']['twitter']) {
                                        $check_twitter = 'checked="checked"';
                                    }
                                    if ($settings['network']['instagram'] && !empty($settings['instagram_client_id'])) {
                                        $check_instagram = 'checked="checked"';
                                    }
                                ?>
                                <input type="checkbox" name="ep_hashimage_network[twitter]" value="twitter" <?php echo $check_twitter; ?>>
                                Twitter
                                <br/>
                                <?php $instagram_disabled = empty($settings['instagram_client_id']) ? 'disabled="disabled"' : ''; ?>
                                <input type="checkbox" name="ep_hashimage_network[instagram]" value="instagram" <?php echo $check_instagram; ?> <?php echo $instagram_disabled; ?>>
                                Instagram
                                <?php if ($instagram_disabled) : ?>
                                    <p class="description">You need to add a Instagram API client id to be able to search for images on instagram!</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                Choose networks
                            </th>
                            <td>
                                <input type="checkbox" name="ep_hashimage_networks[instagram]" value="instagr.am" <?php echo !empty($settings['networks']['instagram']) ? 'checked="checked"' : ''; ?>> Instagram
                                <br/>
                                <input type="checkbox" name="ep_hashimage_networks[twitpic]" value="twitpic" <?php echo !empty($settings['networks']['twitpic']) ? 'checked="checked"' : ''; ?>> Twitpic
                                <br/>
                                <input type="checkbox" name="ep_hashimage_networks[twitter]" value="pic.twitter.com" <?php echo !empty($settings['networks']['twitter']) ? 'checked="checked"' : ''; ?>> pic.twitter.com
                                <br/>
                                <input type="checkbox" name="ep_hashimage_networks[yfrog]" value="yfrog" <?php echo !empty($settings['networks']['yfrog']) ? 'checked="checked"' : ''; ?>> yFrog
                                <br/>
                                <input type="checkbox" name="ep_hashimage_networks[flickr]" value="flic.kr" <?php echo !empty($settings['networks']['flickr']) ? 'checked="checked"' : ''; ?>> Flickr
                                <br/>
                                <input type="checkbox" name="ep_hashimage_networks[plixi]" value="plixi" <?php echo !empty($settings['networks']['plixi']) ? 'checked="checked"' : ''; ?>> Plixi
                                <p class="description">(Used only when searching on twitter)</p>
                            </td>
                        </tr>
                        
                        <tr valign="top">
                            <th scope="row">
                                Instagram Client Id
                            </th>
                            <td>
                                <input type="text" name="ep_hashimage_instagram_client_id" value="<?php echo !empty($settings['instagram_client_id']) ? $settings['instagram_client_id'] : ''; ?>" class="regular-text">
                                <p class="description">To be able to use the instagram API that this plugin use, you need a client_id from Instagram. More info over att <a href="http://instagram.com/developer/">instagram docs</a> or follow <a href="http://darkwhispering.com/wp-plugins/ep-hashimage/get-a-instagram-client_id-key">this guide</a>.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="ep_hashimage_async,ep_hashimage_img_display,ep_hashimage_refresh,ep_hashimage_img_sizes,ep_hashimage_instagram_client_id,ep_hashimage_network,ep_hashimage_networks" />

                <input type="submit" name="submit" value="Save" class="button button-primary" />
            </form>

            <br/><h2 class="title">Tools</h2><br/>

            <form method="post">
                <input type="submit" class="button-secondary" value="Clear cache" name="clear_cache">
            </form>
            <p class="description">Only use this if you don't have any other caching pugin installed. If you have a caching plugin, you need to clear the cache in the that plugins settings</p>
                
            <!-- <p>For help, documentations and examples on how to use EP Hashimage. <a href="">Visit the documentations</a></p> -->

            <br/><h2 class="title">How to use</h2>
            <p>There is three ways to use EP Hashimage on your Wordpress website. Either you use the available template tag, the shortcode or the included widget. More information about each option below.</p>
            
            <h4>Template Tag</h4>
                Just add <pre>echo hashimage($hashtag,$limit);</pre> anywhere in your template.
                <br/>
                Code example: <pre>&lt;&quest;php echo hashimage('hashtag=unicorn&amp;limit=5'); &quest;></pre>
            
            <h4>Shortcode</h4>
                Anywhere in a post or page text, add <pre>[hashimage $hastag $limit]</pre>
                <br/>
                Code example: <pre>[hashimage hashtag="unicorn" limit="5"]</pre>

            <h4>Widget</h4>
                Go to your widget page and look for <strong>EP Hashimage</strong> and move it to your widget area. Options are title, hashtag and limit.
        </div>
    <?php
    }
}

function ep_hashimage_settings() {
    $settings_panel = new epHashimageSettings;
    return $settings_panel->hashimage_panel();
}

function hashimage_menu() {
    add_submenu_page('options-general.php', 'EP Hashimage Settings', 'EP Hashimage', 'manage_options', 'ep-hashimage', 'ep_hashimage_settings');
}
add_action('admin_menu','hashimage_menu');