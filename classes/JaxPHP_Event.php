<?php

/**
 * Class JaxPHP_Event
 *
 * @property string start_date
 * @property string end_date
 * @property string location
 */
class JaxPHP_Event {
	const POST_TYPE = 'jaxphp_event';
	const META_KEY_START = '_jaxphp_event_start';
	const META_KEY_END = '_jaxphp_event_end';
	const META_KEY_LOCATION = '_jaxphp_event_location';

	/** @var Flightless_Post_Type */
	private static $cpt = NULL;

	private $id = 0;

	public function __construct( $post_id ) {
		$this->id = $post_id;
	}

	public function __get( $name ) {
		if ( method_exists( $this, 'get_'.$name ) ) {
			return $this->{'get_'.$name}();
		} else {
			throw new InvalidArgumentException(sprintf(__('Undefined property: %s', 'jaxphp'), $name));
		}
	}

	public function __set( $name, $value ) {
		if ( method_exists( $this, 'set_'.$name ) ) {
			return $this->{'set_'.$name}( $value );
		} else {
			throw new InvalidArgumentException(sprintf(__('Undefined property: %s', 'jaxphp'), $name));
		}
	}

	public function get_start_date() {
		return get_post_meta($this->id, self::META_KEY_START, TRUE);
	}

	public function set_start_date( $date ) {
		if ( !is_int($date) ) {
			$date = strtotime($date);
		}
		if ( empty($date) ) {
			delete_post_meta($this->id, self::META_KEY_START);
		} else {
			$date = date('Y-m-d', $date);
			update_post_meta($this->id, self::META_KEY_START, $date);
		}
	}

	public function get_end_date() {
		return get_post_meta($this->id, self::META_KEY_END, TRUE);
	}

	public function set_end_date( $date ) {
		if ( !is_int($date) ) {
			$date = strtotime($date);
		}
		if ( empty($date) ) {
			delete_post_meta($this->id, self::META_KEY_END);
		} else {
			$date = date('Y-m-d', $date);
			update_post_meta($this->id, self::META_KEY_END, $date);
		}
	}

	public function get_location() {
		return get_post_meta($this->id, self::META_KEY_LOCATION, TRUE);
	}

	public function set_location( $value ) {
		update_post_meta($this->id, self::META_KEY_LOCATION, $value);
	}

	public function get_formatted_dates() {
		$start = strtotime($this->get_start_date());
		$end = strtotime($this->get_end_date());

		if ( empty($end) ) {
			return date('M j, Y', $start);
		}

		// get date and time information from timestamps
		$d1 = getdate($start);
		$d2 = getdate($end);

		// three possible formats for the first date
		$first_long = "M j, Y";
		$first_short = "M j";
		$second_long = $first_long;
		$second_short = "j, Y";

		// decide which format to use
		if ($d1["year"] != $d2["year"]) {
			$first_format = $first_long;
			$second_format = $second_long;
		} elseif ($d1["mon"] != $d2["mon"]) {
			$first_format = $first_short;
			$second_format = $second_long;
		} else {
			$first_format = $first_short;
			$second_format = $second_short;
		}

		return sprintf("%s &ndash; %s\n", date($first_format, $start), date($second_format, $end));
	}


	public static function register_post_type() {
		self::$cpt = new Flightless_Post_Type(self::POST_TYPE);
		self::$cpt->remove_support(array('author'));
		self::$cpt->set_post_type_label(__('Event', 'jaxphp'), __('Events', 'jaxphp'));
		self::$cpt->map_meta_cap = TRUE;
		self::$cpt->slug = _x('events', 'post type slug', 'jaxphp');
		add_flightless_meta_box(self::POST_TYPE, 'JaxPHP_Event_Details_MetaBox');
	}
}
