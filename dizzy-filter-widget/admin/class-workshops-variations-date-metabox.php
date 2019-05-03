<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
if( ! class_exists( 'Workshops_Variations_Date_Metabox' ) ) {
    class Workshops_Variations_Date_Metabox {
 
        public function __construct() {
            add_action( 'woocommerce_variation_options', array($this, 'add_field_to_variations'), 1, 3 ); 
            add_action( 'woocommerce_save_product_variation', array($this, 'save_field_meta'), 10, 2 );
            add_action( 'woocommerce_update_product', array( $this, 'save_locations'), 1);
            // add_filter( 'woocommerce_available_variation', array($this, 'add_field_variation_data') );
        }

        public $meta_field_month = 'workshop_variation_month';

        public $meta_field_year = 'workshop_variation_year';
 
        public function add_field_to_variations($loop, $variation_data, $variation){

            woocommerce_wp_select( array( 
                'id'          => 'workshop_variation_month['. $loop .']', 
                'label'       => __( 'Workshop Month', 'woocommerce' ), 
                'desc_tip'    => true,
                'description' => __( 'Select month of variation to show in workshops widget filter.', 'woocommerce' ),
                'value'       => get_post_meta( $variation->ID, $this->meta_field_month, true ),
                'class' => 'short', 
                'wrapper_class' => 'form-row form-row-first',
                'options' => array(
                    'none'   => __( 'Select month', 'woocommerce' ),
                    'January'   => __( 'January', 'woocommerce' ),
                    'February'   => __( 'February', 'woocommerce' ),
                    'March' => __( 'March', 'woocommerce' ),
                    'April' => __( 'April', 'woocommerce' ),
                    'May' => __( 'May', 'woocommerce' ),
                    'June' => __( 'June', 'woocommerce' ),
                    'July' => __( 'July', 'woocommerce' ),
                    'August' => __( 'August', 'woocommerce' ),
                    'September' => __( 'September', 'woocommerce' ),
                    'October' => __( 'October', 'woocommerce' ),
                    'November' => __( 'November', 'woocommerce' ),
                    'December' => __( 'December', 'woocommerce' )
                    )
                )
            );

            woocommerce_wp_text_input( array( 
                'id' => 'workshop_variation_year[' . $loop . ']', 
                'placeholder' => '20XX',
                'type' => 'number',
                'class' => 'short', 
                'desc_tip'    => true,
                'description' => __( 'Select year of variation to show in workshops widget filter.', 'woocommerce' ),
                'wrapper_class' => 'form-row form-row-last',
                'label' => __( 'Workshop Year', 'woocommerce' ),
                'value' => get_post_meta( $variation->ID, $this->meta_field_year, true ),
                'custom_attributes' => array(
                                'step'  => 'any',
                                'min'   => date("Y")
                            ) 
                ) 
            ); 
        }


        public function save_field_meta( $variation_id, $i ){
            $variation = new WC_Product_Variation($variation_id);
            $parent_id = $variation->get_parent_id();
            $month = $_POST[$this->meta_field_month][$i];
            $year = $_POST[$this->meta_field_year][$i];
            if ( ! empty( $month ) && ! empty( $year ) ) {
                //the top two updates are for showing what we saved previously in the form
                update_post_meta( $variation_id, $this->meta_field_month, esc_attr( $month ) );
                update_post_meta( $variation_id, $this->meta_field_year, esc_attr( $year ) );

                //this is what the query will actually look for because returning parent products with certain variations is difficult if not impossible
                update_post_meta($parent_id, 'workshop_month_year_'.$variation_id, esc_attr( $month.'_'.$year ));
            } 

        }

        public function save_locations( $product_id  ){
            $variable_product = new WC_Product_Variable( $product_id  );            
            $variation_count = count($variable_product->get_children());

            //start empty array to collect locations
            $locations = array();
          
            //find all of the locations being posted in the form
            $location_ids = $_POST['_dei_workshop_location'];

            //add 'em all to the array
            foreach($location_ids as $location_id){
                array_push($locations, $location_id);
            }

            //make sure array isn't empty and is equal to number of variations. if 'save changes' is clicked on variations, it will update the array to only include the changed variation. this way will only update the post meta when the post is updated, which submits all variations
            if ( count($location_ids) === $variation_count ) {
                update_post_meta($product_id , 'workshop_locations', $locations);
            }
        }

    }
}

$workshops_variations_date_metabox = new Workshops_Variations_Date_Metabox();

//at this point, if variation changes are saved, it won't update post unless update button is clicked