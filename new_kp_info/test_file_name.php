<?php
// Если в директории есть файл log.txt, файл будет сохранен с названием log_1.txt
function safe_file($filename)
{
	$dir = dirname($filename);
	if (!is_dir($dir)) {
		mkdir($dir, 0777, true);
	}
 
	$info = pathinfo($filename);
	$name = $dir . '/' . $info['filename']; 
	$prefix = '';
	$ext = (empty($info['extension'])) ? '' : '.' . $info['extension'];
 
	if (is_file($name . $ext)) {
		$i = 1;
		$prefix = '_' . $i;
		while (is_file($name . $prefix . $ext)) {
			$prefix = '_' . ++$i;
		}
	}

	return $name . $prefix . $ext;
}  
 

