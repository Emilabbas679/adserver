/*
Designer: Xatai
Site: Xpert.az
Facebook: https://fb.com/xetai.isayev
*/

$(document).ready(function(){
	
	// Sub menu
	$('.has-sub a').on('click', function(e){
		e.preventDefault();
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
		$('.dropdown-menu').hide();
		$('.profile-block').removeClass('open');
		$('.vsb-main').removeClass('act');
		$('.popover span').fadeOut(300); 
    });
	
	// Select2
	$('.select-ns').select2({ width: '100%', minimumResultsForSearch: -1 });
	
	// Select tag
	$('.select-tag').select2({ width: '100%', minimumResultsForSearch: -1});
	
	// Dropdown
	$('.dropdown').on('click', '.d-button', function(e) {
		e.stopPropagation();
		$('.d-button').not($(this)).next($('.dropdown-menu')).hide();
		$(this).next('.dropdown-menu').toggle();
	});
	
	// Modal
	var btn = $(".mbtn");
    var modal = $(".modal");
    var span = $(".x-close");
    var x = $("body");
    btn.click(function(e) {
        e.preventDefault();
        modal.hide();
        $(($(this).attr("data-target"))).show();
        x.addClass("openmodal");
    });
    span.click(function() {
        modal.hide();
        x.removeClass("openmodal");
    });
    $(document).click(function(event) {
        var target = $(event.target);
        if (target.is(modal)) {
            modal.hide();
            x.removeClass("openmodal");
        }
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            modal.hide();
            x.removeClass("openmodal");
        }
    });
	
	// Alert
	$('.a-close').on('click', function() {
		$(this).parent('.alert').remove();
	});
	
	// User menu
	$('.my-profile').on('click', function(e){
		e.stopPropagation();
		$('.profile-block').toggleClass('open');
	});
	
	$('.profile-block').on('click', function(e){
		e.stopPropagation();
	});
	
	// Popover
	$('.popover').on('click', function(e){
		e.stopPropagation();
		$('.popover span').not($(this).children('span')).fadeOut(300);
		$(this).children('span').fadeToggle(300);
	});
	
	$('.popover span').on('click', function(e){
		e.stopPropagation();
	});
	
});