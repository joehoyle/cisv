<!-- begin right sidebar -->
<div>
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>
<li><h2>Bookmarks:</h2>
	<ul>
	<?php wp_list_bookmarks(); ?>
	</ul>
</li>
<li>
<h2>Tags:</h2>
<?php wp_tag_cloud(''); ?>
</li>

<li><h2>Meta</h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php wp_meta(); ?>
</ul>
</li>
<li><h2>RSS Feeds:</h2>
<ul>
<li><a href="<?php bloginfo('rdf_url'); ?>"><acronym title="Resource Description Framework">RDF</acronym>/<acronym title="Really Simple Syndication">RSS</acronym> 1.0</a></li>
<li><a href="<?php bloginfo('rss_url'); ?>"><acronym title="Really Simple Syndication">RSS</acronym> 0.92</a></li>
<li><a href="<?php bloginfo('rss2_url'); ?>"><acronym title="Really Simple Syndication">RSS</acronym> 2.0</a></li>
<li><a href="<?php bloginfo('atom_url'); ?>">Atom</a></li>
</ul>
</li>
<?php endif; ?>
</ul>
</div>
<!-- end  right sidebar -->
