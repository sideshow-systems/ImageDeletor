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
		
		//echo "<pre>";
		$result = $this->makeULLI($this->readDirR($this->dataDir));
		//echo "</pre>";
		
		return $result;
	}
	
	private function readDirR($dir = "./") {
		$listing = opendir($dir);
		$return = array();
		while(($entry = readdir($listing)) !== false) {
			if ($entry != "." && $entry != ".." && substr($entry, 0, 1) != '.') {
				$dir = preg_replace("/^(.*)(\/)+$/", "$1", $dir);
				$item = $dir . "/" . $entry;
				if (is_file($item)) {
					$return[] = '';
				} else if (is_dir($item)) {
					$return[$entry] = $this->readDirR($item);
				} else {
					
				}
			} else {
				
			}
		}
		return $return;
	}
	
	private function makeULLI($array) {
		$return = "<ul>";
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v) && count($v) > 0) {
					$return .= "<li>" . $k . $this->makeULLI($v) . "</li>";
				} else {
					$return .= "<li>" . $v . "</li>";
				}
			}
		} else {}
		$return .= "</ul>";
		return $return;
	}
}

?>
