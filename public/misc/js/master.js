/** master js file **/

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
			init: function() {},
			dirlistarea: null,
			dataDir: '/vagrant/data',
			
			init: function() {
				this.dirlistarea = $('#dirlist');
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
						console.log(result);
						
						
					}
				});
			}
			
		};
		ImageDeletor.init();
		
		ImageDeletor.getDirList();
	});

});