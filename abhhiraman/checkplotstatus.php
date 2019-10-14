<?php
  
  include 'mobiledb.php';
  include 'Sanddb.php';
  
  $CompanyId = $_GET['CompanyId'];
  
  $query="select PjctId, Sector, Title from Master.ProjectsData where Cid='$CompanyId';";
  $exequery = sqlsrv_query($sandconn, $query);
  while($row=sqlsrv_fetch_object($exequery))
  {
	  $data[] = $row;
  }
  
  echo json_encode($data);
  sqlsrv_free_stmt($exequery);
  
?>