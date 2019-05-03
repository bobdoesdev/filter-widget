

// const pattern = /&product_cat=/g;

// const url = window.location.href;

// const new_url = url.replace(pattern, ',');

// if (url !== new_url) {
// 	window.location.href = new_url;


(function($) {

	$(document).ready(function() {
	    $('#workshop-filter').submit(function() {
	    	$('#workshop-filter').children('select').each(function(){
	    		console.log(this);
	    		if ($(this).val() === ''){
	    			$(this).attr('disabled', true);
	    		}
	    	});
     	})
	});


})(jQuery);