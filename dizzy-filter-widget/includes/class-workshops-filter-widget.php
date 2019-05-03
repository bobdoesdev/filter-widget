<?php

defined( 'ABSPATH' ) || exit;

if( ! class_exists( 'Workshop_Filter_Widget' ) ) {

	class Workshop_Filter_Widget extends WP_Widget {

		/**
		 * Sets up a new filter widget for Workshop product category
		 *
		 */
		public function __construct() {
			$widget_ops = array(
				'classname' => 'workshop_filter_widget',
				'description' => __( 'Filter Workshop Products' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'workshop_filter_widget', __('Workshop Product Filter'), $widget_ops );
			add_action( 'widgets_init', array($this, 'register_new_widget') );
			add_action('wp_enqueue_scripts', array($this, 'create_styles') );
		}

		public function register_new_widget() {
			register_widget( 'Workshop_Filter_Widget' );
		}

		public function create_styles(){
			wp_enqueue_style('workshop-filter', plugin_dir_url(__DIR__) . 'public/css/workshop-filter.min.css', array(), '1', 'all' );
		}

		public function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', $instance['title'] );
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				if ( ! empty( $title ) )
					echo $args['before_title'] . $title . $args['after_title'];

			echo $args['before_widget'];

			?>

			<form action="" method="GET" id="workshop-filter">

			<?php  

				include_once plugin_dir_path(__DIR__) . 'public/date-select.php'; 

				include_once plugin_dir_path(__DIR__) . 'public/specialty-select.php'; 

				include_once plugin_dir_path(__DIR__) . 'public/topic-select.php'; 

				include_once plugin_dir_path(__DIR__) . 'public/location-select.php'; 

			?>
			
			<p>
				<input type='submit' class="button" value='Filter!' name="workshop-filter-submit">
			</p>
			
			</form>

			<?php 

			echo $args['after_widget'];
		}

		/**
		 * Handles updating settings for the current widget instance.
		 *
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = sanitize_text_field( $new_instance['title'] );
			}
			if ( ! empty( $new_instance['nav_menu'] ) ) {
				$instance['nav_menu'] = (int) $new_instance['nav_menu'];
			}
			return $instance;
		}

		/**
		 * Outputs the settings form for the current widget instance.
		 *
		 * @since 3.0.0
		 *
		 * @param array $instance Current settings.
		 * @global WP_Customize_Manager $wp_customize
		 */
		public function form( $instance ) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php 

		}

		public function call_widget(){
			if ( is_product_category( 'workshops' )) {
				the_widget( 'Workshop_Filter_Widget');
			}
		}
	}

}


$diy_categories = new Workshop_Filter_Widget();


// <?php
// 		$product_args = array(
// 		   'post_type'             => 'product',
// 		   'post_status'           => 'publish',
// 		   'ignore_sticky_posts'   => 1,
// 		   'category_name '        => 'workshops',
// 		   'posts_per_page'        => '-1',
// 		);

// 		$products = get_posts( $product_args );

// 		foreach ($products as $product) {
// 			echo '<pre>';
// 			$variable_product = new WC_Product_Variable($product->ID);
// 			$variations = $variable_product->get_variation_attributes();
// 			//init empty array that will be filled and used for select
// 			$month_years = array();

// 			foreach ($variations['pa_when'] as $key => $value) {
// 				echo '<br>'. $value;
// 			}

// 		}

