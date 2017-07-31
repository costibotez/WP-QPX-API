<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://costinbotez.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="panel panel-primary">
	<div class="panel-heading"><?php _e( 'Available flights', 'wp-qpx-api' ); ?></div>
	<div class="panel-body">
		<table class="table table-hover">
		<?php $featured = get_option( 'qpx_no_featured_flights' ); 	// Get the number of highlighted featured  ?>
		<?php foreach ($trip_options->trips->tripOption as $key => $trip) : ?>
			<tr class="flight <?php echo $featured > 0 ? 'list-group-item-success' : ''; ?>">
				<td class="price"><?php echo $trip->saleTotal; ?></td>
				<td>
					<table class="table">
						<tr>
							<td><?php echo date("g:i A", strtotime( $trip->slice[0]->segment[0]->leg[0]->departureTime )); ?> - <?php echo date("g:i A", strtotime( $trip->slice[0]->segment[0]->leg[0]->arrivalTime )); ?> (<?php echo Wp_Qpx_Api_Public::convert_minutes_to_hours($trip->slice[0]->duration); ?>)</td>
							<td><?php echo $trip->slice[0]->segment[0]->leg[0]->origin; ?> - <?php echo $trip->slice[0]->segment[0]->leg[0]->destination; ?></td>
						</tr>
						<tr>
							<td><?php echo date("g:i A", strtotime( $trip->slice[1]->segment[0]->leg[0]->departureTime )); ?> - <?php echo date("g:i A", strtotime( $trip->slice[0]->segment[0]->leg[0]->arrivalTime )); ?> (<?php echo Wp_Qpx_Api_Public::convert_minutes_to_hours($trip->slice[1]->duration); ?>)</td>
							<td><?php echo $trip->slice[1]->segment[0]->leg[0]->origin; ?> - <?php echo $trip->slice[1]->segment[0]->leg[0]->destination; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php $featured--; ?>
			<?php
			//echo '<pre>'; print_r($value); echo '</pre>'; ?>
		<?php endforeach; ?>
		</table>
	</div>
</div>
<?php //echo '<pre>'; print_r(json_decode($request)); echo '</pre>'; ?>
