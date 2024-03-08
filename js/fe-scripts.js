jQuery(document).ready(function () {
  // console.log(jQuery(".mec-single-event .mec-events-event-image").height(), (jQuery(".mec-single-event .mec-events-event-image").height()+100 ) * -1 );
  
  // adjust single event data position on larger screens
  if (jQuery(window).width() >= 480) {
    jQuery(".mec-single-event > .col-md-8").css('margin-top', (jQuery(".mec-single-event .mec-events-event-image").height() + 85) * -1);
  }

  var grid = jQuery('.mec-daily-view-dates-events');
  
	jQuery(grid).find('.mec-event-article').each(function(){
    var event_link = jQuery(this).find('.mec-event-title a');
  
    jQuery(this).find('.mec-event-image img').on('click', function () {
      event_link[0].click()
		});
	});

});