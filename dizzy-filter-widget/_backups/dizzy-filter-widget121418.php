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
	require_once plugin_dir_path(__FILE__) . 'admin/class-workshops-variations-date-metabox.php';

}



function dei_register_query_vars( $vars ) {
	$vars[] = 'workshop-month-year';
	// $vars[] = 'key2';
	return $vars;
}
add_filter( 'query_vars', 'dei_register_query_vars' );


function myplugin_pre_get_posts( $query ) {
	// check if the user is requesting an admin page 
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}
	// edit the query only when post type is 'food'
	// if it isn't, return
	if ( !is_post_type_archive( 'product' ) ){
		return;
	}
	$meta_query = array();
	// add meta_query elements
	if( !empty( get_query_var( 'workshop-month-year' ) ) ){
		$meta_query[] = array( 'key' => 'workshop_month_year', 'value' => get_query_var( 'workshop-month-year' ), 'compare' => 'LIKE' );
	}
	if( count( $meta_query ) > 1 ){
		$meta_query['relation'] = 'AND';
	}
	if( count( $meta_query ) > 0 ){
		$query->set( 'meta_query', $meta_query );
		$query->set( 'post_type', 'product_variation' );
	}
}
add_action( 'pre_get_posts', 'myplugin_pre_get_posts', 1 ); 

//this should return post parent of variable products with that meta data
$posts_meta_id = $wpdb->get_results(SELECT '_parent_product' FROM wp_postmeta WHERE 'workshop_month_year');
// foreach ($posts_with_meta as $posts_meta_id) {
// 	$wpdb->get_results(SELECT 'post_parent' FROM wp_posts WHERE 'workshop_month_year');
// }

// $wpdb->get_results(SELECT 'post_id' FROM wp_postmeta WHERE 'workshop_month_year');

// SELECT * FROM {wpdb->prefix}posts WHERE 'ID' 


//get ids of posts that have workshop_month_year meta
//get ids of post parent
//return

//&product_cat=workshops
//taxonomy=

//not finding variable products. need to find variable products and return regular product. might need to do a straightt SQL query to find the parent products of product variations that include this



//https://codepen.io/the_ruther4d/post/custom-query-string-vars-in-wordpress
//https://www.smashingmagazine.com/2016/03/advanced-wordpress-search-with-wp_query/
//https://premium.wpmudev.org/blog/building-customized-urls-wordpress/


//https://developer.wordpress.org/reference/functions/add_query_arg/
//https://wordpress.stackexchange.com/questions/246516/woocommerce-filter-by-parent-products-taxonomy-and-product-variations-meta-da




// wp query deep dive
//https://premium.wpmudev.org/blog/mastering-wp-query/