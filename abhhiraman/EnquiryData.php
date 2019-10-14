<?php
  include 'Sanddb.php';
  include 'mobiledb.php';
  
  $VentureId = $_GET['VentureId'];
  $SectorId = $_GET['SectorId'];
  $PlotNo = $_GET['PlotNo'];
  $Name = $_GET['Name'];
  $MobileNo = $_GET['MobileNo'];
  $curdate = (String)Date('d-m-y');
  
  $selectquer="select Status from Master.PlotMaster where PLOTNUM='$PlotNo' and PVENTURE='$VentureId' and PSECTOR='$SectorId' and Status='N';";
  $exeselect=sqlsrv_query($sandconn,$selectquer);
  $Status = sqlsrv_fetch_array($exeselect,SQLSRV_FETCH_ASSOC);
  $pStatus = $Status['Status'];
  
  if($pStatus == 'N')
  {
	  $enqinsert = "insert into Master.Enquiry(Name, PlotNo, MobileNo, CreatedOn, VentureCd, SectorCd) values ('$Name', '$PlotNo', '$MobileNo', '$curdate', '$VentureId', '$SectorId');";
	  $exeinsert=sqlsrv_query($mobconn,$enqinsert);
	  if($exeinsert)
	  {
		  echo "Enquiry Generated";
		  sqlsrv_free_stmt($exeselect);
	  }
	  else
	  {
		  echo "fail";
		  sqlsrv_free_stmt($exeselect);
	  }
  }
  else
  {
	  echo "Plot Already Alloted";
	  sqlsrv_free_stmt($exeselect);
  }
	
?>