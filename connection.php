<?php
$db_host = 'localhost';
$db_username = 'Reesh';
$db_password = '90j@Lwuvs[n*l]lb';
$db_database = 'ventaautos';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('No es posible conectarese a la base de datos ['. $db->connect_error .']');
}