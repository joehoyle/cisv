<li class="vevent <?php echo $class; ?>">
	<span class="gigpress-sidebar-date">
		<a href=" <?php bloginfo('url') ?>/kalender"><abbr class="dtstart" title="<?php echo $showdata['iso_date']; ?>"><?php echo $showdata['date']; ?></abbr>
		<?php if($showdata['end_date']) : ?>
			 - <abbr class="dtend" title="<?php echo $showdata['iso_end_date']; ?>"><?php echo $showdata['end_date']; ?></abbr>: <abbr><?php echo $showdata['artist']; ?></abbr>
		<?php endif; ?></a>
	</span>
	<span class="summary">
	<?php if($group_artists || $artist || $total_artists == 1) :
		// We don't need to show the artist name if we're grouping by artist,
		//	or if we''re only showing a single artist,
		// but we still need the text there for the hCalendar ?>
		<span class="hide"><?php endif;
		// start hiding ?>
		<span class="gigpress-sidebar-artist"></span> 
		<span class="gigpress-sidebar-prep"><!-- <?php _e("in", "gigpress"); ?>  --></span> 
		<?php if($group_artists || $artist || $total_artists == 1) : // See above ?></span>
		<?php endif; // end hiding ?>
		<span class="gigpress-sidebar-city"><?php echo $showdata['city']; ?></span>
	</span> 
	<span class="gigpress-sidebar-prep">- <!-- <?php _e("at", "gigpress"); ?> --></span> 
	<span class="location gigpress-sidebar-venue"><?php echo $showdata['venue']; ?></span> 
	<?php if($showdata['ticket_link']) : ?>
		<span class="gigpress-sidebar-status"><?php echo $showdata['ticket_link']; ?></span>
	<?php endif; ?>
</li>
