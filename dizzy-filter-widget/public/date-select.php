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
	$month_years = array();
	foreach ($products as $product) {			

		$variable_product = new WC_Product_Variable($product->ID);
		$variations = $variable_product->get_available_variations();
		foreach ($variations as $variation ) {
			$month = get_post_meta($variation['variation_id'], 'workshop_variation_month', true);
			$year = get_post_meta($variation['variation_id'], 'workshop_variation_year', true);
			$month_year = $month.' '.$year;
			if ( $month && $year) {
				//only add to array if date is unique
				if (!in_array($month_year, $month_years)) {
					array_push($month_years, $month_year);
				}
			}
		}
	}

	//sort dates in ascending order
	function compareByTimeStamp($time1, $time2) { 
	    if (strtotime($time1) > strtotime($time2)) 
	        return 1; 
	    else if (strtotime($time1) < strtotime($time2))  
	        return -1; 
	    else
	        return 0; 
	}
	usort($month_years, "compareByTimeStamp"); 

?>

<div class="workshop-filter-group select-wrapper">

	<h3 class="workshop-filter-title">Date</h3>

	<select name="workshop-month-year" id="workshop-month-year">
		<option value="">Select One</option>

		<?php  foreach ($month_years as $month_year) {
			echo '<option value="'.str_replace(' ', '_', $month_year).'">'.$month_year.'</option>';
		} ?>


	</select>

</div>