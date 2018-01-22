/*
* jQuery 1.2.x Plugin
* plugin: light modal
* author: Alexandre Quinto (kintobr[at]gmail.com)
* 
* example: $('div.modal').modalToggle()
* params: 
*	zIndex: 12000,
*	lock: false,
*	fade: true,
*	cssClass: 'modal',
*	overlayAlpha: 50,
*	overlayCssClass: 'overlay'
*/
(function($) {
	var config = {}
	$.fn.modalToggle = function(config)
	{
		var $this = $(this);
		config = $.modalConfig(config, $this);
		$.overlay(config, $this);
		$.modalDraw($this, config);
		if ( typeof callback == 'function' ) config.callback();
	}
	$.modalDefaults =
	{
		zIndex: 12000,
		lock: false,
		fade: true,
		cssClass: 'modal',
		overlayAlpha: 90,
		overlayCssClass: 'overlay'
	}
	$.modalConfig = function(config, element)
	{
		return jQuery.extend($.modalDefaults, config);
	}
	$.modalDraw = function(element, config)
	{
		var overlay = $('div.' + config.overlayCssClass);
		element.css('z-index', config.zIndex);
		if(element.is(':visible')){
			if (config.fade) {
				overlay.fadeOut();
				element.fadeOut();
			} else {
				overlay.hide();
				element.hide();
			}
		} else {
			if (config.fade) {
				overlay.fadeIn();
				element.fadeIn();
			} else {
				overlay.show();
				element.show();
			}
		}
	}
	$.setHeight = function()
	{
		var 	doc = $(document).height(),
			win = $(window).height();
		
		return doc > win ? doc : win;
	}
	$.setWidth = function()
	{
		var 	doc = $(document).width(),
			win = $(window).width();
			
		return doc > win ? doc : win;
	}
	$.overlay = function(config, element)
	{
		$( 'div' ).hasClass( config.overlayCssClass ) == false ?
			$( '<div class="' + config.overlayCssClass + '"></div>' )
				.prependTo( document.body )
				.css({
					'filter': 'alpha(opacity='+config.overlayAlpha+')',
					'opacity': config.overlayAlpha / 100,
					'-moz-opacity': config.overlayAlpha / 100,
					'z-index': config.zIndex - 1
				})
				.height( $.setHeight() )
				.width( $.setWidth() )
				.click(function(){
					$.overlayClick(element, config);
				})
		: null;
	}
	$.overlayClick = function(element, config)
	{ 
		if ( !config.lock ) element.modalToggle(config); 
		return false;
	}
})($);