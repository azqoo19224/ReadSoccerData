<?php
error_reporting(E_ALL & ~E_NOTICE); 

$mc = new Memcached(); 
$mc->addServer("localhost", 11211);
  
for($i = 0;$i<count($mc);$i++)
{
    echo json_encode($mc->get($i));
}
