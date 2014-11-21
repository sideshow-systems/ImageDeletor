<?php

/*
 * ImageDeletor class
 */

require_once '/vagrant/vendor/autoload.php';

/**
 * ImageDeletor
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
		$result = $this->makeULLI($this->readDirR($this->dataDir), $this->dataDir);
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
	
	private function makeULLI($array, $level = '') {
		$return = "<ul>";
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v) && count($v) > 0) {
					$newLevel = $level . '/' . $k;
					$return .= '<li><a href="' . $newLevel . '">' . $k . '</a>' . $this->makeULLI($v, $newLevel) . '</li>';
				} else {
					$return .= '';// '<li>' . $v . '</li>';
				}
			}
		} else {}
		$return .= "</ul>";
		return $return;
	}
	
	public function getImagesForDir($dir) {
		$result = array();
		$scanned_directory = array_diff(scandir($dir), array('..', '.', '.DS_Store'));
		if (!empty($scanned_directory)) {
			foreach ($scanned_directory as $file) {
				$result[] = $dir . '/' . $file;
			}
		}
		return $result;
	}
	
	public function removeImages($images) {
		$result = 0;
		
		if (!empty($images)) {
			$imagesToDelete = json_decode($images);
			if (!empty($imagesToDelete)) {
				foreach ($imagesToDelete as $img) {
					unlink($img);
					$result++;
				}
			}
		}
		
		return $result;
	}
}

?>
