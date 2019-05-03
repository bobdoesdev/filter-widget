<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Taxonomy_Query' ) ) {
    class Workshops_Taxonomy_Query {
 
        public function __construct() {
            // add_filter( 'query_vars', array($this, 'register_query_vars') ); 
            add_action( 'pre_get_posts', array($this, 'pre_get_posts'), 10, 1 );
            // add_filter( 'posts_where', array($this, 'posts_where'), 10, 2 ); 
        }

        // public function register_query_vars( $vars ) {
        // 	//add our custom query 
        // 	// $vars[] = 'workshop-specialty';
        //  //    $vars[] = 'workshop-topic';
        // 	return $vars;
        // }

        public function pre_get_posts( $query ) {
        	//only apply to mian query
        	if ( is_admin() || ! $query->is_main_query() ){
        		return;
        	}
        	// only apply to products
        	if ( !is_post_type_archive( 'product' ) ){
        		return;
        	}

   
            // if( !empty( get_query_var( 'taxonomy' ) === 'product_cat') ){
               //  echo 'thats right!';
               // $query->set( 'tax_query["relation"]', 'OR' );
            // }
            // echo '<pre>';
            // print_r($query);

    
        }

        // public function posts_where($where, $query){ 
        //     // Check for our flag/fake query var
        //     if (  true === $query->get( 'wildcard_on_key' )  ){
        //     	//filter the clause
        //     	$new_where = str_replace( 'meta_key =', 'meta_key LIKE', $where );
        //         return $new_where;
        //     }
        //     return $where;
        // }

    }
}

$workshops_taxonomy_query = new Workshops_Taxonomy_Query();



// https://cheekymonkeymedia.ca/blog/using-wordpress-to-query-multiple-taxonomies




// http://rm.digitaleel.net/shop/?product_cat=specialty,topic&workshop-month-year=October_2020