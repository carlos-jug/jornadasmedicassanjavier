<?php
if ( !$imgsDir )
	exit;

$ValidExtension = array('jpg', 'jpeg', 'gif', 'png');
$loadedImages = array();
$absoluteDir = getcwd().'/'.$imgsDir;
$openedDir = opendir($absoluteDir); 

while ( $fileName = readdir($openedDir) )
{
	if ( is_file("$absoluteDir/$fileName") )
	{
		$fileInfo = pathinfo("$absoluteDir/$fileName");
		if ( in_array(strtolower($fileInfo['extension']),$ValidExtension) )
			$loadedImages[] = $fileName;
	}
}
sort($loadedImages);
closedir($openedDir);
?>