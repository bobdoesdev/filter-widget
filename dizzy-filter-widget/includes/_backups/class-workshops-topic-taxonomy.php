<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Topic_Taxonomy' ) ) {
    class Workshops_Topic_Taxonomy {
 
        public function __construct() {
            add_action( 'init', array($this, 'register_taxonomy_item'), 1, 3 ); 
        }

        public function register_taxonomy_item()  {

            $labels = array(
                'name'                       => 'Topics',
                'singular_name'              => 'Topic',
                'menu_name'                  => 'Topics',
                'all_items'                  => 'All Topics',
                'parent_item'                => 'Parent Topic',
                'parent_item_colon'          => 'Parent Topic:',
                'new_item_name'              => 'New Topic Name',
                'add_new_item'               => 'Add New Topic',
                'edit_item'                  => 'Edit Topic',
                'update_item'                => 'Update Topic',
                'separate_items_with_commas' => 'Separate Topic with commas',
                'search_items'               => 'Search Topics',
                'add_or_remove_items'        => 'Add or remove Topics',
                'choose_from_most_used'      => 'Choose from the most used Topics',
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
            register_taxonomy( 'topic', 'product', $args );

        }

    }
}

$workshops_topic_taxonomy = new Workshops_Topic_Taxonomy();

