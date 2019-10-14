<?php
$serverName = "183.82.117.243";
$connection = array("UID"=>"telex","PWD"=>"extech","Database"=>"AB2018");
$sandconn = sqlsrv_connect( $serverName, $connection);
if ($sandconn) {
  
}else{
	
	die( print_r( sqlsrv_errors(), true));
}
?>