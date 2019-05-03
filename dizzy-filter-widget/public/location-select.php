<?php 

	//loop through the products we need
	$product_args = array(
	   'post_type'             => 'product',
	   'post_status'           => 'publish',
	   'ignore_sticky_posts'   => 1,
	   'category_name '        => 'workshops',
	   'posts_per_page'        => '-1',
	);

	$products = get_posts( $product_args );

	//start empty array to later add products too and populate our dropdown
	$locations = array();
	foreach ($products as $product) {			

		$variable_product = new WC_Product_Variable($product->ID);
		$variations = $variable_product->get_children();
		foreach ($variations as $variation ) {
			$location = get_post_meta($variation, '_dei_workshop_location', true);
			if ( $location ) {
				//only add to array if date is unique
				if (!in_array($location, $locations)) {
					array_push($locations, $location);
				}
			}
		}
	}

?>

<div class="workshop-filter-group select-wrapper">

	<h3 class="workshop-filter-title">Location</h3>

	<select name="workshop-location" id="workshop-location">
		<option value="">Select One</option>
		<?php  foreach ($locations as $location) {
			echo '<option value="'.$location.'">'.get_post_meta($location, 'wpsl_city', true).'</option>';
		} ?>

	</select>

</div>


         