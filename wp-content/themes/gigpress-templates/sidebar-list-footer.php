<?php // Show the "more" link if specified
if($gpo['sidebar_link'] == 1) : ?>
	<p class="gigpress-sidebar-more"><a href="<?php echo gigpress_check_url($gpo['shows_page']); ?>" title="<?php echo wptexturize($gpo['upcoming_phrase']); ?>"><?php echo wptexturize($gpo['upcoming_phrase']); ?></a></p>
<?php endif; ?>

<?php // Show the RSS/iCal links if specified
if($gpo['widget_feeds'] == 1) : ?>
	<p class="gigpress-subscribe"><?php _e("Subscribe", "gigpress") ;?>: 

	<?php if(!$artist && !$tour) : ?>
		<a href="<?php echo GIGPRESS_RSS; ?>" title="<?php echo wptexturize($gpo['rss_title']); ?> RSS" class="gigpress-rss">RSS</a>&nbsp;<a href="<?php echo GIGPRESS_WEBCAL; ?>" title="<?php echo wptexturize($gpo['rss_title']); ?> iCalendar" class="gigpress-ical">iCal</a>
	<?php endif; ?>

	<?php if($artist) : ?>
		<a href="<?php echo GIGPRESS_RSS; ?>&amp;artist=<?php echo $showdata['artist_id']; ?>" title="<?php echo $showdata['artist']; ?> RSS" class="gigpress-rss">RSS</a> | <a href="<?php echo GIGPRESS_WEBCAL; ?>&amp;artist=<?php echo $showdata['artist_id']; ?>" title="<?php echo $showdata['artist']; ?> iCalendar" class="gigpress-ical">iCal</a>
	<?php endif; ?>	
		
	<?php if($tour) : ?>
		<a href="<?php echo GIGPRESS_RSS; ?>&amp;tour=<?php echo $showdata['tour_id']; ?>" title="<?php echo $showdata['tour']; ?> RSS" class="gigpress-rss">RSS</a> | <a href="<?php echo GIGPRESS_WEBCAL . '&amp;tour=' . $showdata['tour_id']; ?>" title="<?php echo $showdata['tour']; ?> iCalendar" class="gigpress-ical">iCal</a>
	<?php endif; ?>	
				
	</p>

<?php endif; ?>	