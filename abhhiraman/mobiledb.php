<?php
$serverName = "183.82.126.49";
$connection = array("UID"=>"telex","PWD"=>"extech","Database"=>"MobileApps");
$mobconn = sqlsrv_connect( $serverName, $connection);
if ($mobconn) {

}else{
	
	die( print_r( sqlsrv_errors(), true));
}
?>