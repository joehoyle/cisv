<!-- begin left sidebar -->
<div id="sidebar_left">
<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>


<li>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</li>

<li><h2>Calendar:</h2>
<?php get_calendar(true); ?>
</li>

<li><h2>Pages:</h2>
<ul>
<?php wp_list_pages('title_li='); ?> 
</ul>
</li>

<li><h2>Categories:</h2>
<ul>
<?php wp_list_categories('title_li='); ?>
</ul>
</li>

<li><h2>Archives:</h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>

<li>
<h2>W3C Validators:</h2>
<a href="http://validator.w3.org/check?uri=referer">
<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" />
</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer">
<img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
</a>
</li>
 
<?php endif; ?>
</ul>
</div>
<!-- end left sidebar -->
