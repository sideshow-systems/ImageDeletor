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


	});

});