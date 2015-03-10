<?php

require_once('YapiCacheMemcache.class.php');

$m = new Memcache;

$cache = new YapiCacheMemcache;			// <------ Using Memcache....Cache

$tmp_object = 'testing testing...';

echo 'Installed: ' . $cache->isInstalled() .'<br><br>';
echo 'Avaible: ' . $cache->isAvailable() .'<br><br>';

$cache->setData('key', $tmp_object, false);
 
$get_result = $cache->getData('key');  
echo "Data from the cache:<br/><br/>\n";  
  
var_dump($get_result); 

?>