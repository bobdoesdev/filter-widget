<?php 

	$parent = get_term_by('slug', 'specialty', 'product_cat');

	$specialty_args = array(
		'taxonomy' 		=> 'product_cat',
		'child_of'		=>	$parent->term_id,
		'hide_empty' 	=> 0,

	);

	$specialty_subs = get_terms($specialty_args);

?>

<div class="workshop-filter-group select-wrapper">

	<h3 class="workshop-filter-title">Specialty</h3>
	
	<select name="product_cat_specialty" id="product_cat_specialty">
		<option value="">Select One</option>
		<?php  foreach ($specialty_subs as $specialty_sub) {
			echo '<option value="'.str_replace(' ', '-', $specialty_sub->name).'">'.$specialty_sub->name.'</option>';
		} ?>
	</select>

</div>