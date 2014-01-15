<?php

/*
 * can be called by AJAX calls from client with ?src=http://full.domain.com/path/to/image.{png,jpeg}
 * 
 * @param	(string)	url of external image to fetch
 * @url		http://stackoverflow.com/questions/5838566/upload-external-image-and-save-it-on-my-server
 * @url		http://stackoverflow.com/questions/35879/base64-encoding-image
 */

$src = $_GET['src'];

$aContext = array(
    'http' => array(
        'proxy' => 'tcp://wwwcache.univ-lr.fr:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);

//$sFile = file_get_contents("http://www.google.com", False, $cxContext);

$image = file_get_contents($src, False, $cxContext);
$data = base64_encode($image);

echo $data;

?>
