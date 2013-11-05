<?php

/**
 * Class JaxPHP_Event_Details_MetaBox
 */
class JaxPHP_Event_Details_MetaBox extends Flightless_Meta_Box {
	public function __construct( $post_type, $args = array() ) {
		$this->defaults['title'] = __('Event Details', 'jaxphp');
		$this->defaults['context'] = 'side';
		$this->defaults['priority'] = 'high';
		parent::__construct($post_type, $args);
	}

	/**
	 * @param object $post The post being edited
	 *
	 * @return void
	 */
	public function render( $post ) {
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui');
		$event = new JaxPHP_Event($post->ID);
		include(dirname(dirname(__FILE__)).'/views/meta-box-event-details.php');
	}

	/**
	 * @param int $post_id The ID of the post being saved
	 * @param object $post The post being saved
	 * @return void
	 */
	protected function save( $post_id, $post ) {
		$event = new JaxPHP_Event($post->ID);
		$event->start_date = $_POST['jaxphp-event-start'];
		$event->end_date = $_POST['jaxphp-event-end'];
		$event->location = $_POST['jaxphp-event-location'];
	}
}
