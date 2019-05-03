<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Specialty_Taxonomy' ) ) {
    class Workshops_Specialty_Taxonomy {
 
        public function __construct() {
            add_action( 'init', array($this, 'register_taxonomy_item'), 1, 3 ); 
        }

        public function register_taxonomy_item()  {

            $labels = array(
                'name'                       => 'Specialties',
                'singular_name'              => 'Specialty',
                'menu_name'                  => 'Specialties',
                'all_items'                  => 'All Specialties',
                'parent_item'                => 'Parent Specialty',
                'parent_item_colon'          => 'Parent Specialty:',
                'new_item_name'              => 'New Specialty Name',
                'add_new_item'               => 'Add New Specialty',
                'edit_item'                  => 'Edit Specialty',
                'update_item'                => 'Update Specialty',
                'separate_items_with_commas' => 'Separate Specialty with commas',
                'search_items'               => 'Search Specialties',
                'add_or_remove_items'        => 'Add or remove Specialties',
                'choose_from_most_used'      => 'Choose from the most used Specialties',
            );
            $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => false,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
            );
            register_taxonomy( 'specialty', 'product', $args );

        }

    }
}

$workshops_specialty_taxonomy = new Workshops_Specialty_Taxonomy();

