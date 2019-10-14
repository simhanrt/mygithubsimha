<?php
  session_start();
  include 'Sanddb.php';
  
  $VentureId = $_GET['VentureId'];
  $SectorId = $_GET['SectorId'];
  $PlotNo = $_GET['PlotNo'];
  $Staval = $_GET['Status'];
  $curdate = (String)Date('d-m-y');
  $count=$_GET['Id'];
  $key=implode('-', str_split(substr(strtolower($count), 0, 32), 6));
  
  
  
  
  
  //get plot status
  $select="select Status from Master.PlotMaster where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId';";
  $exesel=sqlsrv_query($sandconn,$select);
  $Status = sqlsrv_fetch_array($exesel,SQLSRV_FETCH_ASSOC);
  $pStatus = $Status['Status'];
  
  if($Staval != $pStatus)
  {
    switch ($Staval) {
		
    case "N":
        if($pStatus == 'R')
		{
			$selectquer="update master.PlotMaster set Status='$Staval', ApiKey = '$key', ModifiedDate = CURRENT_TIMESTAMP where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId';";
			$exeselect=sqlsrv_query($sandconn,$selectquer);
			  if($exeselect)
			  {
				  echo "Success";
			  }
			  else
			  {
				  echo "fail";
			  }
		}
		else
		{
			echo "Sold";
		}
        break;
		
		case "R":
        if($pStatus == 'N')
		{
			$selectquer="update master.PlotMaster set Status='$Staval' , ApiKey = '$key', ModifiedDate = CURRENT_TIMESTAMP where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId';";
			$exeselect=sqlsrv_query($sandconn,$selectquer);
			  if($exeselect)
			  {
				  echo "Success";
			  }
			  else
			  {
				  echo "fail";
			  }
		}
		else
		{
			echo "Sold";
		}
        break;
		
		case "Y":
        if($pStatus == 'N')
		{
			$selectquer="update master.PlotMaster set Status='$Staval', ApiKey = '$key', ModifiedDate = CURRENT_TIMESTAMP where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId';";
			$exeselect=sqlsrv_query($sandconn,$selectquer);
			  if($exeselect)
			  {
				  echo "Success";
			  }
			  else
			  {
				  echo "fail";
			  }
		}
		else
		{
			echo "Reserved";
		}
        break;
		
    }
   }
   else
   {
 	  echo "Same";
   }
 // sqlsrv_free_stmt($exesel);
  //sqlsrv_free_stmt($exeselect);
  //$selectquer="update master.PlotMaster set Status='$Staval' where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId'";
   
?>