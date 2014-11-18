/** master js file **/

head.ready(function() {

	$(document).ready(function() {

		// menu trigger
		$('#menu_trigger').click(function() {
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
			
			init: function() {
				this.dirlistarea = $('#dirlist');
			},
			getDirList: function() {
				var ImgDel = this;
				$.ajax({
					url: ImageDeletor.ajaxUrl,
					type: 'POST',
					data: {
						action: 'getdirs'
					},
					success: function(data) {
						var result = jQuery.parseJSON(data);
						console.log(result);
						
						// TODO: check if result.dirs is not empty!
						var $dirStructure = $(result.dirs);
						
						// TODO: remove empty nodes
						
						
						ImgDel.dirlistarea.html($dirStructure);
					}
				});
			}
			
		};
		ImageDeletor.init();
		
		ImageDeletor.getDirList();
	});

});