<?php
	// Figure out how many columns this table has.  Base is 3 (date, city, venue).
	// If we're NOT grouping by artist, and we're NOT displaying just a single artist, add a column (for artist).
	// If we're displaying the country, add another.
	// We don't use this variable in this template, but we do need it in subsequent templates
	$cols = 3;
	$cols = ($total_artists == 1 || $artist || $group_artists == 'yes') ? $cols : $cols + 1;
	$cols = ($gpo['display_country'] == 1) ? $cols + 1 : $cols;
?>

<table class="gigpress-table <?php echo $scope; ?> hcalendar" cellspacing="0" cellpadding="0">
	<tbody>
		<tr class="gigpress-header">
			<th scope="col" class="gigpress-date"><?php _e("Date", "gigpress"); ?></th>
		<?php if( (!$artist && $group_artists == 'no' || $tour) && $total_artists > 1) : ?>
			<th scope="col" class="gigpress-artist">Aktivitet</th>
		<?php endif; ?>
			<th scope="col" class="gigpress-city"><?php _e("City", "gigpress"); ?></th>
			<th scope="col" class="gigpress-venue<?php if($venue) : ?> hide<?php endif; ?>"><?php _e("Venue", "gigpress"); ?></th>
		<?php if($gpo['display_country'] == 1) : ?>
			<th scope="col" class="gigpress-country"><?php _e("Country", "gigpress"); ?></th>
		<?php endif; ?>
		</tr>
	</tbody>
	