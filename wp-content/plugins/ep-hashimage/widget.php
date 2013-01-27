<?php

// Load the widget it self
add_action('widgets_init','load_ep_hashimage_widget');

// Get widget class
function load_ep_hashimage_widget() {
    register_widget('ep_hashimage_widget');
}

// Widget class
class ep_hashimage_widget extends WP_Widget{

    function ep_hashimage_widget() {
        //Settings
        $widget_ops = array('classname'=>'ephashimagewidget','description'=>__('Add hashimages to your widget area.','ephashimagewidget'));
        
        //Controll settings
        $control_ops = array('id_base' => 'ephashimagewidget');
        
        //Create widget
        $this->WP_Widget('ephashimagewidget',__('EP Hashimage'),$widget_ops,$control_ops);
        
    }
    
    // Widget frontend code
    function widget($args,$instance) {
        extract($args);
        
        //User selected settings
        $title      = $instance['title'];        
        // $twitter    = $instance['twitter'];
        // $instagram  = $instance['instagram'];

        // if ($twitter && $instagram) {
        //     $network = 'both';
        // } else if ($twitter) {
        //     $network = $instance['twitter'];
        // } else if ($instagram) {
        //     $network = $instance['instagram'];
        // }

        $hashimage_args = array(
            'hashtag'   => $instance['hashtag'],
            'limit'     => $instance['limit'],
            // 'network'   => $network,
            'type'      => 'widget'
        );

        echo $before_widget;
        ?>
            
            <?php echo $before_title . $title . $after_title; ?>
            
            <div class="images">
                <?php
                    if (!empty($hashimage_args)) {
                        if (function_exists('hashimage')) {
                            echo hashimage($hashimage_args);
                        }
                    }
                ?>
            </div>
        
        <?php
        echo $after_widget;
    }
    
    // Widget update. It's here the magic is happening when saving
    function update($new_instance,$instance) {
        $instance['title']      = strip_tags($new_instance['title']);
        $instance['hashtag']    = strip_tags($new_instance['hashtag']);
        $instance['limit']      = strip_tags($new_instance['limit']);
        // $instance['twitter']    = strip_tags($new_instance['twitter']);
        // $instance['instagram']  = strip_tags($new_instance['instagram']);

        return $instance;
    }

    // Widget backend, the options for the widget in WP admin
    function form($instance) {
        // This is where you set the default values, if you want any.
        $default = array(
            'title'     => 'Hashimages',
            'hashtag'   => 'unicorn',
            'limit'     => 5
            // 'twitter'   => 'twitter',
            // 'instagram' => 'instagram'
        );
        $instance = wp_parse_args((array)$instance,$default);
        
        // Your settings form. No start, end or submit tags is needed here, wordpress ad this itself later in admin
    ?>
        <!-- TITLE -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:'); ?></label>
            <br />
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
        </p>
        
        <!-- HASHTAG -->
        <p>
            <label for="<?php echo $this->get_field_id('hashtag'); ?>"><?php echo __('Hashtag:'); ?></label>
            <br />
            <input type="text" id="<?php echo $this->get_field_id('hashtag'); ?>" name="<?php echo $this->get_field_name('hashtag'); ?>" value="<?php echo $instance['hashtag']; ?>" class="widefat" />
        </p>
        
        <!-- LIMIT -->
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php echo __('Limit:'); ?></label>
            <br />
            <input type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo $instance['limit']; ?>" class="widefat" />
        </p>

        <?php /*
        <p>
            Search on:
            <input type="checkbox" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="twitter" <?php echo $instance['twitter'] ? 'checked="checked"' : ''?> />
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php echo __('Twitter'); ?></label>

            <input type="checkbox" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" value="instagram" <?php echo $instance['instagram'] ? 'checked="checked"' : ''?> />
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php echo __('Instagram'); ?></label>
        </p>
        */ ?>
    
    <?php
    }
}