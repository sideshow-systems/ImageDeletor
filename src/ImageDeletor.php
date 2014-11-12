<?php

/*
 * ImageDeletor class
 */

require_once '/vagrant/vendor/autoload.php';

/**
 * Description of ImageDeletor
 *
 * @author Florian Binder <fb@sideshow-systems.de>
 */
class ImageDeletor {
	
	public function getDirs() {
		$result = array();
		
		/*
		$scanner = new \TheSeer\DirectoryScanner\DirectoryScanner();
		$scanner->addInclude('-r');
		
		foreach($scanner('/vagrant/data') as $i) {
			error_log($i);
			$result[] = $i;
		}
		*/
		
		$path = '/vagrant/data';
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
		foreach ($objects as $name => $fileInfo) {
			echo $name . "<br />\n";
			print_r($fileInfo);
			/*
			if ($fileInfo->isDot()) continue;
			$name = $fileInfo->getFilename();
			if (substr($fileInfo, 0, 1) != '.') {
				echo $fileInfo->getFilename() . "<br>\n";
			}
			*/
		}
		
		return $result;
	}
	
}

?>
