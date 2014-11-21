<?php
/**
 * Ajax trigger file
 */

require_once '../src/ImageDeletor.php';

$params = $_REQUEST;
$imageDeletor = new ImageDeletor();

$result = array();

switch ($params['action']) {
	case 'getdirs':
		$dirs = $imageDeletor->getDirs();
		$result = array('dirs' => $dirs);
		
		break;
	case 'getimagesfordir':
		$imgs = $imageDeletor->getImagesForDir($params['dir']);
		$result = array('imgs' => $imgs);
		break;
	case 'removeimgs':
		$removed = $imageDeletor->removeImages($params['imgs']);
		$result = array('removed' => $removed);
		break;
	default:
		break;
}

echo json_encode($result);
?>
