<?php
require_once "DB.php";

DB::pdoConnect();

$sql = "SELECT * FROM `data`";
$select = DB::$db->prepare($sql);
$select->execute();
$data = $select->fetchall();

error_reporting(E_ALL & ~E_NOTICE); 

$mc = new Memcached(); 
$mc->addServer("localhost", 11211);

$index = 0;
$keyArray = array();
$arr = array();

foreach ($data as $val) {
    $mc->set($index, serialize($data));
    $index++;
}

for ($i=0;$i < $index; $i++) {
    $arr[] = $mc->get($i);
}

echo json_encode($arr);
