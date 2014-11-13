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
	
	private $dataDir = '/vagrant/data';
	
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
		
		$ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->dataDir), RecursiveIteratorIterator::CHILD_FIRST); 
		foreach ($ritit as $splFileInfo) { 
			if ($splFileInfo->isDir() && ($splFileInfo->getFilename() != '.' || $splFileInfo->getFilename() != '..')) {
				$path = $splFileInfo->isDir() 
					? array($splFileInfo->getFilename() => array()) 
					: array($splFileInfo->getFilename()); 
				
				for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) { 
					$path = array($ritit->getSubIterator($depth)->current()->getFilename() => $path);
				}
				$result = array_merge_recursive($result, $path);
			}
		}
		
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		
		return $result;
	}
	
}

?>
