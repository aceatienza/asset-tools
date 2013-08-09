define(['jquery'], function($){
    var portfolio = function(){
		var that,
			$assetItem,
			$assetsInPortfolio,
			$assetItemInPortfolio,
			$assetList,
			$delete;

        return {
			init: function(){
				that = this;
				$assetItem = $('.assetList .assetItem');
				$assetsInPortfolio = $('.assetsInPortfolio');
				$assetItemInPortfolio = $('.assetsInPortfolio .assetItem');
				$delete = $('.assetItem .delete-item');
				$assetList = $('.assetList');

				that.bindEvents();
			},
			bindEvents: function(){
				$assetItem.on('click', that.selectItem);

				$assetItemInPortfolio.on({
					mouseenter: function(){
						$(this).children('.delete-item').show();
					},
					mouseleave: function(){
						$(this).children('.delete-item').hide();
					}
				});

				$delete.on('click', function(event){
					that.removeItem(this);
				});
			},
			selectItem: function(){
				// .clone() instead?
				var $self = $(this);
				var id = $self.data('item-id');

				var $selectedImg = $($self.child('img'));
				var thumbnail = $selectedImg.attr('src');
				var title = $selectedImg.attr('alt');

				// TODO: remove hardcoded name. dynamically add it
				// Let's start the habit of using the fastest way to create elements
				var $input = $(document.createElement('input'));
				$input.attr({
					value: id,
					name: 'asset_ids[]',
					type: 'hidden'
				});
				
				var $img = $(document.createElement('img')); // the preview thumbnail
				$img.attr({
					src: thumbnail,
					alt: title,
					style: "opacity: 0;"
				});

				var $span = $(document.createElement('span'));
				$span.attr({
					class: 'delete-item',
					style: 'display: none;'
				});
				$span.append('X');

				// Create a new li and stuff it
				var $li = $(document.createElement('li'));
				$li.attr({
					class: 'assetItem',
					'data-item-id': id
				});
				$li.append($input, $img, $span);

				$assetsInPortfolio.append($li);

				$self.fadeOut(300, function(){
					console.log('selectItem fadeout');
					$img.animate({ opacity: 1}, 300);
				});

				// need to re-attach delete. maybe clone() or create with jquery fixes this?
				// need to add hovers too
				$li.on('click', function(){
					console.log(this);
					console.log('remove new item');
					that.removeItem(this);
				});
			},
			removeItem: function(event){

				// delete is not attaching itself to new item

				var $self = $(event);
				var li = $self.parent();
				var idnow = li.data('item-id');

				li.animate({opacity: 0}, 300, function(){
					// slide up row only if last item in row is deleted
					var $innerself = $(this);
					$(this).slideUp(500, function(){
						$innerself.remove();
					});
				});

				// $assetList.find(); // ?
				// var returnedItem = $('.assetList li').attr('data-item-id', idnow); // incorrect
				// var returnedItem = $('.assetList li[value='+ id +']');

				// do I need to validate this?
				console.log('removeItem');

				// find matching id among $assetItem
				// fadeback in

				 // keep track of whether the event handler has been 
				 // installed already, either in a global variable or using jQuery's .data() on element

			}

        };
    };
    return portfolio;

});