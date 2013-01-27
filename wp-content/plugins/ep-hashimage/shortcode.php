<?php

function hashimage_shortcode($args = array()){
    if (function_exists('hashimage')) {
        return hashimage($args);
    }
}
add_shortcode('hashimage', 'hashimage_shortcode');

?>