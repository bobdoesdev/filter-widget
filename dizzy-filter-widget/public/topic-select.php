<?php 

	$parent = get_term_by('slug', 'topic', 'product_cat');

	$topic_args = array(
		'taxonomy' 		=> 'product_cat',
		'child_of'		=>	$parent->term_id,
		'hide_empty' 	=> 0,

	);

	$topic_subs = get_terms($topic_args);

?>

<div class="workshop-filter-group select-wrapper">

	<h3 class="workshop-filter-title">Topic</h3>
	
	<select name="product_cat_topic" id="product_cat_topic">
		<option value="">Select One</option>
		<?php  foreach ($topic_subs as $topic_sub) {
			echo '<option value="'.str_replace(' ', '-', $topic_sub->name).'">'.$topic_sub->name.'</option>';
		} ?>
	</select>

</div>