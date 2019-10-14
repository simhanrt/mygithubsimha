<?php
 include 'db.php';
 
 $VentureId=$_GET['VentureId'];
 $PassbookNo=$_GET['PassbookNo'];
 $CommCalc=$_GET['CommCalc'];
 
 
 
 $data=array();
 $SelQuery="select * from master.Member_Agent_Details
 where VentureCd='$VentureId' and PBNO='$PassbookNo';";
 
 $exeque=sqlsrv_query($conn,$SelQuery);
 $row=sqlsrv_fetch_array($exeque);
 for($i=1;$i<=20;$i++)
 {
   $temp="AGENCODE".$i;
   $Initial="INITIAL".$i;
   $Install_Comm="INST".$i;
   $Total_Amo="TOTCOM".$i;
   $Discount="DISCOUNT".$i;
   $GrossPayable="GrossPayable".$i;
   $AgCode = $row[$temp];

   if($AgCode != 'OFF' && $AgCode != "")
   {
	 if($CommCalc=='A')
	 {		 
	 $getName="select distinct[AgentName] as AgName ,AgentLevel as AgLevel,AgentCadre as AgCadre  from master.Agent where AgentCd='$AgCode';";
	 $exenamequ=sqlsrv_query($conn,$getName);	
	 $Name=sqlsrv_fetch_array($exenamequ,SQLSRV_FETCH_ASSOC);
	 $rowdata= array('Index'=>$i,'AgentCode'=>$AgCode,'AgentName'=>$Name['AgName'],'AgentLevel'=>$Name['AgLevel'],'AgentCadre'=>$Name['AgCadre'],"Commission"=>$row[$Install_Comm],"Total_Amo"=>$row[$Total_Amo],"Discount"=>$row[$Discount],"GrossPayable"=>$row[$GrossPayable]);
	 $data[]=$rowdata;
	 }
	 else
	 {
	 $getName="select distinct[AgentName] as AgName ,AgentLevel as AgLevel,AgentCadre as AgCadre  from master.Agent where AgentCd='$AgCode';";
	 $exenamequ=sqlsrv_query($conn,$getName);	
	 $Name=sqlsrv_fetch_array($exenamequ,SQLSRV_FETCH_ASSOC);
	 $rowdata= array('Index'=>$i,'AgentCode'=>$AgCode,'AgentName'=>$Name['AgName'],'AgentLevel'=>$Name['AgLevel'],'AgentCadre'=>$Name['AgCadre'],"Commission"=>$row[$Initial],"Total_Amo"=>$row[$Total_Amo],"Discount"=>$row[$Discount],"GrossPayable"=>$row[$GrossPayable]);
	 $data[]=$rowdata; 
	 }
   }
   else
   {
	   break;
   }
 }
echo json_encode($data);
 
?>