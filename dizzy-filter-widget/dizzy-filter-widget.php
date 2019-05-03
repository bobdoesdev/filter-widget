<?php
/*
Plugin Name: Workshop Filter Widget
Plugin URI: https://woocommerce.com/
Description: Custom Taxonomy Filtering for Dizzy Workshops
Version: 1.0.0
Author: WooThemes
Author URI: https://woocommerce.com/
*/

defined( 'ABSPATH' ) || exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	require_once plugin_dir_path(__FILE__) . 'includes/class-workshops-filter-widget.php';
	require_once plugin_dir_path(__FILE__) . 'includes/class-workshops-date-query.php';
	require_once plugin_dir_path(__FILE__) . 'admin/class-workshops-variations-date-metabox.php';

}






// wp query deep dive
//https://premium.wpmudev.org/blog/mastering-wp-query/

//https://stackoverflow.com/questions/33873478/how-to-redirect-to-another-page-in-php-based-on-drop-down-selected-value-text