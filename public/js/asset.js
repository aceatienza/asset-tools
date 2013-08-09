define(['jquery'], function($){
    var asset = function(){
		var that,
			$vimeoId,
			$vimeoTitle,
			$vimeoUrl,
			$videoItem,
			$dropZone,
			$previewAsset,
			$videoThumbnail,
			$dropZoneContainer;

        return {
			init: function(){
				that = this;

				$vimeoId = $('#vimeo_id');
				$vimeoTitle = $('#vimeo_title');
				$vimeoUrl = $('#vimeo_url');
				$vimeoThumbnail = $('#vimeo_thumbnail');
				$videoItem = $('.video_item');
				$dropZone = $('.dropzone');
				$dropZoneContainer = $('.dropzoneContainer');
				$previewAsset = $('.preview-asset');

				that.bindEvents();
			},
			bindEvents: function(){
				$videoItem.on('click', that.selectItem);
			},
			selectItem: function(){
				var self = $(this);
				var title = self.attr('title');
				var id = self.data('item-id');
				var url = self.data('url');
				var thumbnail = self.data('thumb');

				// insert the values into form
				$vimeoId.attr('value', id);
				$vimeoTitle.attr('value', title);
				$vimeoUrl.attr('value', url);
				$vimeoThumbnail.attr('value', thumbnail);

				// remove any highlighted item first before highlighting						
				$videoItem.removeClass("highlight");
				self.addClass('highlight');

				$dropZone.fadeOut(300, function(){
					$dropZoneContainer.html('<img style="display: none;" src="'+thumbnail+'">').find('img').fadeIn();

					// TODO: attach event handler to new img to remove selection
					// TODO: hide choose file button
				});

				// TODO: add ability to remove selected Vimeo

			}
        };
    };
    return asset;

});