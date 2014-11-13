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
			
			getDirList: function() {
				$.ajax({
					url: ImageDeletor.ajaxUrl,
					type: 'POST',
					data: {
						action: 'getdirs'
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						console.log(obj);
					}
				});
			}
			
		};
		
		ImageDeletor.getDirList();
	});

});