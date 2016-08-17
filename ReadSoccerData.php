<?php 
ignore_user_abort(true);
 
set_time_limit(0);

require_once "DB.php";

DB::pdoConnect();

$interval = 60;

do{
    error_reporting(E_ALL & ~E_NOTICE); 
    
    $sql = "SELECT * FROM `data`";
    $select = DB::$db->prepare($sql);
    $select->execute();
    $data = $select->fetchall();

    $mc = new Memcached(); 
    $mc->addServer("localhost", 11211);
    
    $index = 0;
    
    foreach ($data as $val){
        $mc->set($index, serialize($data));
        $index++;
    }
    
    sleep($interval);
}while(true);

