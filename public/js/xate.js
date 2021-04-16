/*
Designer: Xatai
Site: Xpert.az
Facebook: https://fb.com/xetai.isayev
*/

$(document).ready(function(){
	
	// Sub menu
	$('.has-sub a').on('click', function(){
		$('.sub-menu').not($(this).next()).slideUp()
		$('.has-sub').not($(this).parent('li')).removeClass('active')
		$(this).next('.sub-menu').slideToggle();
		$(this).parent('li').toggleClass('active');
	});
	
	// Scroll
	$('.scrl').scrollbar();
	
	$('.content-inner').on('click', '.tools', function(e) {
		e.stopPropagation();
		$('.tools').not($(this)).next($('.tools-list')).hide();
		$(this).next('.tools-list').toggle();
	});
	
	$(document).click(function() {
		$('.tools-list').hide();
    });
	
	// Select2
	$('.select-ns').select2({ width: '100%', minimumResultsForSearch: -1 });
	
});