<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Date_Query' ) ) {
    class Workshops_Date_Query {
 
        public function __construct() {
            add_filter( 'query_vars', array($this, 'register_query_vars') ); 
            add_action( 'pre_get_posts', array($this, 'pre_get_posts'), 10, 1 );
            add_filter( 'posts_where', array($this, 'posts_where'), 10, 2 ); 
            add_action( 'wp', array($this, 'redirect_form') ); 
        }

        public function register_query_vars( $vars ) {
        	//add our custom query 
        	$vars[] = 'workshop-month-year';
            $vars[] = 'workshop-location';
        	return $vars;
        }

        public function pre_get_posts( $query ) {
        	//only apply to mian query
        	if ( is_admin() || ! $query->is_main_query() ){
        		return;
        	}
        	// only apply to products
        	if ( !is_post_type_archive( 'product' ) ){
        		return;
        	}

        	$meta_query = array();
        	// add meta_query elements
        	if( !empty( get_query_var( 'workshop-month-year' ) ) ){
        		$meta_query[] = array( 
        			//this sets our pattern so it pulls in all meta keys that start with 'workshop_month_year'
        			'key' => 'workshop_month_year%', 
        			'value' => get_query_var( 'workshop-month-year' ), 
        			'compare' => 'LIKE',
        			 );
        	}

            if( !empty( get_query_var( 'workshop-location' ) ) ){
                $meta_query[] = array( 
                    //this sets our pattern so it pulls in all meta keys that start with 'workshop_month_year'
                    'key' => 'workshop_locations', 
                    'value' => get_query_var( 'workshop-location' ), 
                    'compare' => 'LIKE',
                     );
            }

        	if( count( $meta_query ) > 1 ){
        		$meta_query['relation'] = 'AND';
        	}
        	if( count( $meta_query ) > 0 ){
        		$query->set( 'meta_query', $meta_query );
        		//set our flag/fake query var for editing the query later
        		$query->set( 'wildcard_on_key', true );
        	}
        }

        public function posts_where($where, $query){ 
            // Check for our flag/fake query var
            if (  true === $query->get( 'wildcard_on_key' )  ){
            	//filter the clause
            	$new_where = str_replace( 'meta_key =', 'meta_key LIKE', $where );
                return $new_where;
            }
            return $where;
        }

        public function redirect_form(){
            if (isset($_GET['workshop-filter-submit'])) {
                        
                if (!empty($_GET['workshop-month-year']) || !empty($_GET['product_cat_specialty']) || !empty($_GET['product_cat_topic']) || !empty($_GET['workshop-location'])) {

                    if (!empty($_GET['workshop-month-year'])) {
                        $date = '&workshop-month-year='.$_GET['workshop-month-year'];
                    }else{
                        $date = '';
                    }

                    if (!empty($_GET['workshop-location'])) {
                        $location = '&workshop-location='.$_GET['workshop-location'];
                    }else{
                        $location = '';
                    }

                    if (!empty($_GET['product_cat_specialty'])) {
                        $specialty = strtolower($_GET['product_cat_specialty']);
                    }

                    if (!empty($_GET['product_cat_topic'])) {
                        $topic = strtolower($_GET['product_cat_topic']);
                    }

                    if ($specialty && $topic) {
                        $combine = '+';
                    } else{
                        $combine = '';
                    }
                    wp_redirect('/market/?product_cat='.$specialty.$combine.$topic.$date.$location);
                    exit;
                }
                if (isset($_GET['workshop-month-year']) ) {
                    if ( empty($_GET['workshop-month-year']) && empty($_GET['product_cat_specialty']) && empty($_GET['product_cat_topic']) && empty($_GET['workshop-location'])){
                        wp_redirect('/product-category/workshops/');
                    }
                }
            }

        }

    }
}

$workshops_date_query = new Workshops_Date_Query();

// https://dizzy.eelcart.com/marketplace/?product_cat=specialty-1&workshop-month-year=February_2019

// product_cat=topic-2+specialty-1

// product_cat=topic-2+specialty-1&workshop-month-year=February_2019

//&product_cat=workshops
//taxonomy=

//not finding variable products. need to find variable products and return regular product. might need to do a straightt SQL query to find the parent products of product variations that include this



//https://codepen.io/the_ruther4d/post/custom-query-string-vars-in-wordpress
//https://www.smashingmagazine.com/2016/03/advanced-wordpress-search-with-wp_query/
//https://premium.wpmudev.org/blog/building-customized-urls-wordpress/


//https://developer.wordpress.org/reference/functions/add_query_arg/
//https://wordpress.stackexchange.com/questions/246516/woocommerce-filter-by-parent-products-taxonomy-and-product-variations-meta-da

// https://wordpress.stackexchange.com/questions/221760/how-do-i-query-for-posts-by-partial-meta-key