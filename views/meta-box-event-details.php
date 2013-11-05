<?php

/**
 * @var JaxPHP_Event $event
 */
?>
<div class="jaxphp-event-details">
	<style type="text/css">
		.jaxphp-event-details label {
			display: block;
			font-weight: bold;
			margin-top: 0.5em;
		}
		.jaxphp-event-details input {
			width: 90%;
			margin-bottom: 1em;
		}
	</style>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$('#jaxphp-event-start, #jaxphp-event-end').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	</script>
	<div class="jaxphp-event-field">
		<label for="jaxphp-event-start"><?php _e('Start Date', 'jaxphp'); ?></label>
		<input type="text" placeholder="YYYY-MM-DD" name="jaxphp-event-start" id="jaxphp-event-start" value="<?php echo $event->start_date; ?>" />
	</div>
	<div class="jaxphp-event-field">
		<label for="jaxphp-event-end"><?php _e('End Date', 'jaxphp'); ?></label>
		<input type="text" placeholder="YYYY-MM-DD" name="jaxphp-event-end" id="jaxphp-event-end" value="<?php echo $event->end_date; ?>" />
	</div>
	<div class="jaxphp-event-field">
		<label for="jaxphp-event-location"><?php _e('Location', 'jaxphp'); ?></label>
		<input type="text" placeholder="City, State" name="jaxphp-event-location" id="jaxphp-event-location" value="<?php echo $event->location; ?>" />
	</div>
</div>