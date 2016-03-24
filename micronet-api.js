jQuery(document).ready(function($) {
	// Ajax loading
	jQuery('#micronet-container').html('<div id="bg-micronet-popup" class="bg-micronet-popup"></div><div class="micronet-popup-loading">'+micronet_obj.loading_img+'</div>');

	/**
	 * AJAX get micronet-api data
	 */
	jQuery.ajax({
		url: micronet_obj.ajax_url,
		type: 'post',
		dataType: 'html',
		data: {
			action: '_micronet_api'
		}
	})
	.done(function(response) {
		console.log("success");
		jQuery('#micronet-container').html(response);
	})
	.fail(function(e) {
		console.log("error");
		console.log(e);
	})
	.always(function() {
		console.log("complete");
		jQuery('.micronet-loading').fadeOut();
	});
	
});

