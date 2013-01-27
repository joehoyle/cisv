<h3 class="gigpress-artist-heading" id="artist-<?php echo $showdata['artist_id']; ?>"><?php echo $showdata['artist']; ?>
<?php if($gpo['display_subscriptions'] == 1) : ?>
	<span class="gigpress-artist-subscriptions">
		<a href="<?php echo GIGPRESS_RSS; ?>&amp;artist=<?php echo $showdata['artist_id']; ?>" title="<?php echo $showdata['artist']; ?> RSS"><img src="<?php echo WP_PLUGIN_URL; ?>/gigpress/images/feed-icon-12x12.png" alt="" /></a>
		&nbsp;
		<a href="<?php echo GIGPRESS_WEBCAL . '&amp;artist=' . $showdata['artist_id']; ?>" title="<?php echo $showdata['artist']; ?> iCalendar"><img src="<?php echo WP_PLUGIN_URL; ?>/gigpress/images/icalendar-icon.gif" alt="" /></a></span>
<?php endif; ?>
</h3>