define(['jquery'], function($){
	var cms = function(){
		var $delete, $setting;

		return {
			init: function(){
				_ = this;

				$delete = $('.delete-item');
				$setting = $('.setting-item');

				_.bindEvents();
			},
			bindEvents: function(){
				$setting.on({
					mouseenter: function(){
						$(this).children('.delete-item').show();
					},
					mouseleave: function(){
						$(this).children('.delete-item').hide();
					}
				});

				$delete.on('click', function(){
					
					_.deleteItem(this);
				});
			},
			deleteItem: function(clickEvent){
				var self = $(clickEvent),
					url = self.data('url'),
					dataName = self.data('name'),
					dataValue = self.data('value');

				$.ajax({
					url: url,
					route: 'POST',
					data: {
						name: dataName,
						value: dataValue
					}
				}).done(function (data){
					$parentDiv = self.parent();
					$parentDiv.animate({
						opacity: 0}, 300,
						function(){ $parentDiv.remove(); } 		// this is kind of jarring. consider replacing with blank div
					);
				}).fail(function(jqXHR, textStatus){
					alert(textStatus);
				});

			},
			destroy: function(){}

		};
	};

	return cms;
});