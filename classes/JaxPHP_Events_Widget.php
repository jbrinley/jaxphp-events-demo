<?php

if ( !class_exists('JaxPHP_Events_Widget') ) {
	class JaxPHP_Events_Widget extends WP_Widget {
		
		protected $instance_defaults = array(
			'title' => 'Upcoming Events',
		);
	
		public function __construct() {
			parent::__construct($this->id_base(), $this->widget_title(), $this->widget_ops(), $this->control_ops());
		}
	
		protected function id_base() {
			return 'jaxphp-events-widget';
		}
	
		protected function widget_title() {
			return __('Upcoming Events', 'jaxphp');
		}
	
		protected function widget_ops() {
			return array(
				'classname' => 'jaxphp-events-widget',
				'description' => __('Shows upcoming events', 'jaxphp')
			);
		}
	
		protected function control_ops() {
			return array(
				'id_base' => $this->id_base(),
			);
		}
	
		public function widget( $args, $instance ) {
			/**
			 * @var string $before_widget
			 * @var string $after_widget
			 * @var string $before_title
			 * @var string $after_title
			 */
			extract( $args );
	
			/**
			 * @var string $title
			 */
			extract( $instance );

			$events = new WP_Query(array(
				'post_type' => JaxPHP_Event::POST_TYPE,
				'meta_key' => JaxPHP_Event::META_KEY_START, // to enable sorting
				'meta_query' => array(array( // to really filter things
					'key' => JaxPHP_Event::META_KEY_START,
					'value' => date('Y-m-d', current_time('timestamp')),
					'compare' => '>=',
					'type' => 'DATE',
				)),
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'posts_per_page' => 5,
			));

			if ( !$events->have_posts() ) {
				return;
			}

			$title = apply_filters( 'widget_title', empty( $title ) ? '' : $title, $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

			// render individual events
			while ( $events->have_posts() ) {
				$events->the_post();
				$event = new JaxPHP_Event(get_the_ID());
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h4 class="event-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jaxphp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
					<p class="event-dates"><?php echo $event->get_formatted_dates(); ?></p>
					<p class="event-location"><?php esc_html_e($event->location); ?></p>
				</article><!-- #post-<?php the_ID(); ?> -->
				<?php
			}
			rewind_posts();

			echo $after_widget;
		}
	
	
		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
			// display the admin form
			$title = strip_tags($instance['title']);
			?>

			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			<?php

		}
	
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			foreach ( $this->instance_defaults as $key => $value ) {
				$instance[$key] = $new_instance[$key];
			}
			return $instance;
		}

		public static function register_widget() {
			register_widget(__CLASS__);
		}

	}
}