/** master js file **/

Array.prototype.last = function() {
	return this[this.length-1];
};

head.ready(function() {

	$(document).ready(function() {

		// menu trigger
		$('#menu_trigger').click(function() {
			ImageDeletor.getDirList();
			$('#dir_chooser').animate({
				right: 0
			});
			return false;
		});

		// hide menu chooser
		$('#dir_chooser .close').click(function() {
			$('#dir_chooser').animate({
				right: -400
			});
			return false;
		});



		var ImageDeletor = {
			ajaxUrl: 'ajax.php',
			dirlistarea: null,
			dataDir: '/vagrant/data',
			previewStack: null,
			removeStack: null,
			keepStack: null,
			previewArea: null,
			removeArea: null,
			keepArea: null,

			init: function() {
				this.dirlistarea = $('#dirlist');
				this.previewArea = $('#preview_area');
				this.removeArea = $('#stack_remove');
				this.keepArea = $('#stack_keep');

				$('#btn_keep').click(function() {
					ImageDeletor.keepImage();
					return false;
				});
				$('#btn_remove').click(function() {
					ImageDeletor.removeImage();
					return false;
				});
			},
			getDirList: function() {
				var ImgDel = this;
				$.ajax({
					url: ImgDel.ajaxUrl,
					type: 'POST',
					data: {
						action: 'getdirs'
					},
					success: function(data) {
						var result = jQuery.parseJSON(data);
						console.log(result);

						// TODO: check if result.dirs is not empty!
						var $dirStructure = $(result.dirs);

						// hijack links
						var $links = $('a', $dirStructure);
						$links.click(function() {
							ImgDel.getImagesForDir($(this).attr('href'));
							return false;
						});

						ImgDel.dirlistarea.html($dirStructure);
					}
				});
			},
			getImagesForDir: function(dir) {
				var ImgDel = this;
				$.ajax({
					url: ImgDel.ajaxUrl,
					type: 'POST',
					data: {
						action: 'getimagesfordir',
						dir: dir
					},
					success: function(data) {
						var result = jQuery.parseJSON(data);
						//console.log(result);

						// TODO: handle empty result

						ImgDel.resetAreas();
						ImgDel.previewStack = result;
						ImgDel.generatePreviewData();
					}
				});
			},
			generatePreviewData: function() {
				if (this.previewStack.length !== 0) {
					var ImgDel = this;
					jQuery.each(this.previewStack.imgs, function(index, path) {
						ImgDel.previewArea.append('<a class="imgwrapper" href="#" rel="' + index + '"><img src="img.php?file=' + path + '" width="400" /></a>');
					});
				}
			},
			getCurrentImageFromPreviewStack: function() {
				return this.previewArea.find('a.imgwrapper').last();
			},
			keepImage: function() {
				var $el = this.getCurrentImageFromPreviewStack();
				this.keepArea.find('.content').append($el.detach());
			},
			removeImage: function() {
				var $el = this.getCurrentImageFromPreviewStack();
				this.removeArea.find('.content').append($el.detach());
			},
			resetAreas: function() {
				this.previewArea.find('a.imgwrapper').remove();
				this.keepArea.find('a.imgwrapper').remove();
				this.removeArea.find('a.imgwrapper').remove();
			}

		};
		ImageDeletor.init();

		ImageDeletor.getDirList();
	});

});