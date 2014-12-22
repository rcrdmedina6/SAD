(function($) {

	$.organicTabs = function(el, options) {
							    
		var base = this;
		base.$el = $(el);
		base.$nav = base.$el.find(".nav");
							                
			base.init = function() {
				base.options = $.extend({},$.organicTabs.defaultOptions, options);
					$(".oculto").css({
						"position": "relative",
						"top": 0,
						"left": 0,
						"display": "none"
			}); 
							            
			base.$nav.delegate("li > a", "click", function() {
				var curList = base.$el.find("a.current").attr("href").substring(1),
				$newList = $(this),
				listID = $newList.attr("href").substring(1),
				$allListWrap = base.$el.find(".list-wrap"),
				curListHeight = $allListWrap.height();
				$allListWrap.height(curListHeight);
							                                        
					if ((listID != curList) && ( base.$el.find(":animated").length == 0)) {
						base.$el.find("#"+curList).fadeOut(base.options.speed, function() {
						base.$el.find("#"+listID).fadeIn(base.options.speed);
						var newHeight = base.$el.find("#"+listID).height();
						$allListWrap.animate({
							height: newHeight
						});
							                        
						base.$el.find(".nav li a").removeClass("current");
							$newList.addClass("current");
						});
							}   
							return false;
						});
							            
						};
						base.init();
						};
							    
						$.organicTabs.defaultOptions = {
							"speed": 300
						};
							    
						$.fn.organicTabs = function(options) {
							return this.each(function() {
							    (new $.organicTabs(this, options));
							});
						};
							    
	})(jQuery);

	jQuery("#menu-apuestas").organicTabs();