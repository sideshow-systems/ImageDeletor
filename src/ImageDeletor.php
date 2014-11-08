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
		//$scanner->addInclude('*.php');
		
		$result = array();
		
		foreach($scanner('/vagrant/public') as $i) {
			$result[] = $i;
		}
		
		return $result;
	}
	
}

?>
