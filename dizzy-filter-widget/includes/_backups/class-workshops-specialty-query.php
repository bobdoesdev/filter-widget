<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Taxonomy_Query' ) ) {
    class Workshops_Taxonomy_Query {
 
        public function __construct() {
            add_filter( 'query_vars', array($this, 'register_query_vars') ); 
            add_action( 'pre_get_posts', array($this, 'pre_get_posts'), 10, 1 );
            // add_filter( 'posts_where', array($this, 'posts_where'), 10, 2 ); 
        }

        public function register_query_vars( $vars ) {
            //add our custom query 
            $vars[] = 'workshop-specialty';
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

            $tax_query = array();
            // add meta_query elements
            if( !empty( get_query_var( 'workshop-specialty' ) ) ){
                $tax_query[] = array( 
                    //this sets our pattern so it pulls in all meta keys that start with 'workshop_month_year'
                    'taxonomy' => 'specialty', 
                    'field' => 'slug', 
                    'terms'         => get_query_var( 'workshop-specialty' ),
                 );
            }

            if( count( $tax_query ) > 1 ){
                $tax_query['relation'] = 'AND';
            }
            if( count( $tax_query ) > 0 ){
                $query->set( 'tax_query', $tax_query );
            }
        }

        // public function posts_where($where, $query){ 
        //     // Check for our flag/fake query var
        //     if (  true === $query->get( 'wildcard_on_key' )  ){
        //      //filter the clause
        //      $new_where = str_replace( 'meta_key =', 'meta_key LIKE', $where );
        //         return $new_where;
        //     }
        //     return $where;
        // }

    }
}

$workshops_taxonomy_query = new Workshops_Taxonomy_Query();



