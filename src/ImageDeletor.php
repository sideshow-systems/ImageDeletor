<?php

/*
 * ImageDeletor class
 */

require_once '../vendor/autoload.php';

/**
 * Description of ImageDeletor
 *
 * @author Florian Binder <fb@sideshow-systems.de>
 */
class ImageDeletor {
	
	public function getDirs() {
		$scanner = new \TheSeer\DirectoryScanner\DirectoryScanner();
		$scanner->addInclude('-r');
		
		$result = array();
		
		foreach($scanner('/vagrant/data') as $i) {
			error_log($i);
			$result[] = $i;
		}
		
		return $result;
	}
	
}

?>
