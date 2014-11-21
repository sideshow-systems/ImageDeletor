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

		// key trigger
		$(document).keyup(function(event) {
//			console.log(event);
			if (event.keyCode === 82) { // r
				ImageDeletor.removeImage();
			} else if (event.keyCode === 75) { // k
				ImageDeletor.keepImage();
			}
		});

		// ImageDeletor
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

				$('#removeimgs').click(function() {
					ImageDeletor.removeImages();
					return false;
				});
			},
			removeImages: function() {
				var ImgDel = this;

				// get imgs we want to delete
				var imgsToDelete = [];
				var imgs = this.removeArea.find('a.imgwrapper');
				imgs.each(function(index, el) {
					imgsToDelete.push($(el).data('delpath'));
				});

				$.ajax({
					url: ImgDel.ajaxUrl,
					type: 'POST',
					data: {
						action: 'removeimgs',
						imgs: JSON.stringify(imgsToDelete, null, 2)
					},
					success: function(data) {
						var result = jQuery.parseJSON(data);
						if (result.removed > 0) {
							ImgDel.removeArea.find('a.imgwrapper').remove();
						}
					}
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
						ImgDel.previewArea.append('<a class="imgwrapper" href="#" rel="' + index + '" data-delpath="' + path + '"><img src="/misc/pics/blank.gif" data-imgpath="img.php?file=' + path + '" /></a>');
					});
					ImgDel.loadCurrentImg();
				}
			},
			getCurrentImageFromPreviewStack: function() {
				return this.previewArea.find('a.imgwrapper').last();
			},
			keepImage: function() {
				var $el = this.getCurrentImageFromPreviewStack();
				this.keepArea.find('.content').append($el.detach());
				this.loadCurrentImg();
			},
			removeImage: function() {
				var $el = this.getCurrentImageFromPreviewStack();
				this.removeArea.find('.content').append($el.detach());
				this.loadCurrentImg();
			},
			resetAreas: function() {
				this.previewArea.find('a.imgwrapper').remove();
				this.keepArea.find('a.imgwrapper').remove();
				this.removeArea.find('a.imgwrapper').remove();
			},
			loadCurrentImg: function() {
				var $el = this.getCurrentImageFromPreviewStack();
				var $imgEl = $el.find('img');
				var imgPath = $imgEl.data('imgpath');
				$imgEl.attr('src', imgPath);
			}

		};
		ImageDeletor.init();

		ImageDeletor.getDirList();
	});

});