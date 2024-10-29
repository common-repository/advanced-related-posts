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

	$(document).ready(function () {
		
		$(document).find('.ays-arp-under-posts-container').each( function( e, index ) {

			var _this = $(this);
			var htmlClassPrefix = '.ays-arp-';

       	 	var uniqueId = _this.attr('data-id');
       	 	var dataRatio = parseInt(_this.attr('data-ratio'));

       	 	if ( typeof dataRatio != 'undefined' ) {
       	 		_this.find( htmlClassPrefix + 'under-post-img').each(function(){
       	 			var $this = $(this);
       	 			var realWidth = $this.width();
       	 			var realheight = $this.height();

       	 			if (dataRatio < 1) {
					    realWidth = realheight * dataRatio;
					} else {
					    realheight = realWidth / dataRatio;
					}

            		var ratio = parseFloat( dataRatio ) * realWidth;
            		$this.height(ratio);
       	 		});
       	 	}
		});
		
	});

})( jQuery );
