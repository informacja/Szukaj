<?php

//    error_reporting(5);
$db_dir = "db";
if( substr($db_dir, -1) != "/")
    $db_dir = $db_dir.'/';


return array(
    'path' => 'mdb/',
    'csv'   => 'db/05.2019.csv',
    'db_dir' => $db_dir,
    'log_request_filename' => "db/log_request.htm",
    'admin_mail' => 'w.kryzia@zst-tarnow.pl',
    'request_save_log' => true
 );
?>