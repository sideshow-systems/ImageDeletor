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
		
		
		
		$result = array('files' => array(), 'directories' => array());
		$DirectoryIterator = new RecursiveDirectoryIterator($this->dataDir);
		$IteratorIterator  = new RecursiveIteratorIterator($DirectoryIterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($IteratorIterator as $file) {
		    $path = $file->getRealPath();
		    if ($file->isDir()) {
		        $result['directories'][] = $path;
		    } elseif ($file->isFile()) {
		        $result['files'][] = $path;
		    }
		}
		$result = array_unique($result['directories']);
		
		
		//echo "<pre>";
		//$result = $this->dirToArray($this->dataDir);
		//$result = $this->fillArrayWithFileNodes(new DirectoryIterator($this->dataDir));
		$result = $this->readDirR($this->dataDir);
		print_r($this->makeULLI($result));
		//echo "</pre>";
		
		return $result;
	}
	
	private function readDirR($dir = "./") {
		$listing = opendir($dir);
		$return = array ();
		while(($entry = readdir($listing)) !== false) {
			if ($entry != "." && $entry != "..") {
				$dir = preg_replace("/^(.*)(\/)+$/", "$1", $dir);
				$item = $dir . "/" . $entry;
				if (is_file($item)) {
					$return[] = $entry;
				}
				elseif (is_dir($item)) {
					$return[$entry] = $this->readDirR($item);
				} else {}
			} else {}
		}
 
		return $return;
	}
	
	private function makeULLI($array) {
		$return = "<ul>\n";
 
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v) && count($v) > 0) {
					$return .= "\t<li>" . $k . $this->makeULLI($v) . "</li>\n";
				}
				else {
					$return .= "\t<li>" . $v . "</li>\n";
				}
			}
		} else {}
 
		$return .= "</ul>";
 
		return $return;
	}
	
	
	
	
	private function fillArrayWithFileNodes(DirectoryIterator $dir) {
		$data = array();
		foreach ( $dir as $node ) {
			if ( $node->isDir() && !$node->isDot() ) {
				$data[$node->getFilename()] = $this->fillArrayWithFileNodes( new DirectoryIterator( $node->getPathname() ) );
			} else if ( $node->isFile() ) {
				$data[] = $node->getFilename();
			}
		}
		return $data;
	}
	
	private function dirToArray($dir) {
	    $contents = array();
	    # Foreach node in $dir
	    foreach (scandir($dir) as $node) {
	        # Skip link to current and parent folder
			if (substr($node, 0, 1) === '.') continue;
	        # Check if it's a node or a folder
	        if (is_dir($dir . DIRECTORY_SEPARATOR . $node)) {
	            # Add directory recursively, be sure to pass a valid path
	            # to the function, not just the folder's name
	            //$contents[$node] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $node);
				$contents[]['subdir'] = array('name' => $node, 'content' => $this->dirToArray($dir . DIRECTORY_SEPARATOR . $node));
	        } else {
	            # Add node, the keys will be updated automatically
	            //$contents[] = $node;
	        }
	    }
	    # done
	    return $contents;
	}
}

?>
