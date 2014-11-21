<?php

/**
 * Handle image requests
 */

$params = $_REQUEST;

if (!empty($params['file'])) {
	$img = $params['file'];
	if (file_exists($img)) {
		echo file_get_contents($img);
	}
}
?>
