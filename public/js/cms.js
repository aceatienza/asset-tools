define(['jquery'], function($){
	// TODO: refactor back to simple closure. This isn't needed and will be harder to maintain
	var cms = function(){
		// internal scope
		var $delete,
			$setting,
			$newService,
			$newServiceFields,
			that = this;

		// Add methods to this object
		that.init = function() {
			$delete = $('.setting-item .delete-item');
			$setting = $('.setting-item');
			$newService = $('#new-service');
			$newServiceFields = $('.new-service');

			that.bindEvents();
		};

		that.bindEvents = function() {

			$setting.on({
				mouseenter: function(){
					$(this).children('.delete-item').show();
				},
				mouseleave: function(){
					$(this).children('.delete-item').hide();
				}
			});

			$newService.on('click', function(){
				$newServiceFields.animate({ opacity: 1}, 300);
			});

			$delete.on('click', function(){
				that.deleteItem(this);
			});
		};

		that.deleteItem = function(clickEvent) {
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
					opacity: 0}, 300
					// function(){ $parentDiv.hide(); }	// this is kind of jarring. 
				);
			}).fail(function(jqXHR, textStatus){
				console.log(textStatus);
			});
		};

		// Return object literal
		return {
			// public  :  private method
			init: that.init,
			deleteItem: that.deleteItem
		};
	};

	return cms;
});