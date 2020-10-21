jQuery(function($){
	$('.tutorials-wrap__item').on('click', function(){
		$(this).next('.tutorials-wrap__vimeo').fadeIn();
		$(this).next('.tutorials-wrap__vimeo').find('.vimeo-frame').addClass('active')
		$('.tutorials-shadow').fadeIn();
	});
	$('.tutorials-shadow').on('click', function(){
		$('.tutorials-shadow, .tutorials-wrap__vimeo').fadeOut();
		
		var iframe = $('.vimeo-frame.active');
	    var player = new Vimeo.Player(iframe);
	    player.pause();
		$('.vimeo-frame').removeClass('active');
	});
});