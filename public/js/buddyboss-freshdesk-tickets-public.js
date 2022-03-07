(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).on('click', '.wp-download-lgs', function(event) {
	 	// event.preventDefault();
	 	/* Act on the event */

	 	var mediaId  = $(this).data('media_id');
	 	var fileName = $(this).data('file_name');
	 	var pageName = $(this).data('page_name');

	 	if (mediaId != '') {
	 		$.ajax({
	 			url: wdl_params.ajax_url,
	 			type: 'POST',
	 			dataType: 'json',
	 			data: { action: 'wp-download-attachments', media_id: mediaId, file_name: fileName, page_name: pageName },
	 		}).done(function(res) {
	 			if (res.error == false) {
	 				// Do nothing
	 			} else {
	 				alert(res.error);
	 			}
	 		});	 		
	 	}
	});

})( jQuery );
