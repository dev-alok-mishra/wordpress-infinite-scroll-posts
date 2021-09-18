// loadmore.js
jQuery(function($){
  // add loading button
	$('#main').append( '<span class="load-more" id="show_more">Loading...</span>' );
	var page = 2;
	var loading = false;
	$(window).scroll(function () {
		var win_scroll = $(this).scrollTop();
		var def_off =  800;
    // loading button offset
		var offset = $('#show_more').offset().top;
		offset = offset - def_off;
		var win_h = $(window).height();
		if ((win_scroll + win_h) > offset) {
			jQuery('#show_more').trigger('click');
		}
	});

	$('body').on('click', '#show_more', function(){
		if( ! loading ) {
			loading = true;
			var data = {
				action: 'infinity_load_load_action',
				page: page,
				postnot: infinityloadmore.post__not_in,
			};
			$.ajax({
			   method: "POST",
			   url: infinityloadmore.url,
			   data: data
			 }).done(function( res ) {
				console.log(res);
				if( res.success) {
					$('.ajax_wrapper').append( res.data );
					page = page + 1;
					loading = false;
				}
			}).fail(function(xhr, textStatus, e) {
				 console.log(xhr.responseText);
			});
		}
	});
		
});
