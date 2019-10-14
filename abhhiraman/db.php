<?php
$serverName = "183.82.117.243";
$connection = array("UID"=>"telex","PWD"=>"extech","Database"=>"AB2018");
$conn = sqlsrv_connect( $serverName, $connection);
if ($conn) {
  
}else{
	
	die( print_r( sqlsrv_errors(), true));
}
?>