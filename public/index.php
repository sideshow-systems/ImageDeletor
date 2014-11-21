<!doctype html>
<html class="no-js" lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>ImageDeletor</title>
		<link rel="stylesheet/less" type="text/css" href="misc/less/master.less" />
		<script src="misc/js/less.min.js" type="text/javascript"></script>
		<script src="misc/js/modernizr-2.8.3.min.js"></script>
		<script src="misc/js/head.load.min.js"></script>
		<script>
			head.load(
					{jquery: 'misc/js/jquery-2.1.1.min.js'},
			{jquery: 'misc/js/master.js'}
			);
		</script>
	</head>
	<body>
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<div id="main_container">
			<div id="header_container">
				ImageDeletor <span>V 0.1</span>
			</div>
			<div id="content_container">
				<div id="stack_remove" class="stack">
					<h4>Remove</h4>
				</div>
				<div id="preview_area" class="stack">
					<!--
					<a href="#"><img width="400" src="img.php?file=/vagrant/data/dir1/02831_autumn_1920x1080.jpg"></a>
					<a href="#"><img width="400" src="img.php?file=/vagrant/data/dir1/02832_newyorkcitybw_1920x1080.jpg"></a>
					<a href="#"><img width="400" src="img.php?file=/vagrant/data/dir1/02833_oiasunset_1920x1080.jpg"></a>
					<a href="#"><img width="400" src="img.php?file=/vagrant/data/dir1/02834_canopy_1920x1080.jpg"></a>
					<a href="#"><img width="400" src="img.php?file=/vagrant/data/dir1/02835_beforethestorm_1920x1080.jpg"></a>
					-->
					<div id="preview_tools">
						<a href="#" id="btn_remove" class="btn">remove image</a>
						<a href="#" id="btn_keep" class="btn">keep image</a>
					</div>
				</div>
				<div id="stack_keep" class="stack">
					<h4>Keep</h4>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
			<div id="footer_container">
				footer
			</div>
		</div>
		<a href="#" id="menu_trigger">Choose Folder</a>
		<div id="dir_chooser">
			<div class="content">
				<h4>Please choose a directory</h4>
				<a href="#" class="close">close</a>
				<div id="dirlist"></div>
			</div>
		</div>
	</body>
</html>