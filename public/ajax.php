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

	default:
		break;
}

echo json_encode($result);
?>
