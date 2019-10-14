<?php
 include 'db.php';
 
 $ApiKey=$_GET['ApiKey'];
 $Prikey = implode('-', str_split(substr(strtolower($ApiKey), 0, 32), 6));
 $data=array();
 $curr_timestamp = $_GET['date'];
 if($curr_timestamp=='now')
	 $curr_timestamp=date('d-m-Y');
 
 
 $superquery="select USERTYPE from dbo.USERS where Apikey='$Prikey';";
 $superexe=sqlsrv_query($conn,$superquery);
 $values=sqlsrv_fetch_array($superexe,SQLSRV_FETCH_ASSOC);
 $superAdmin=$values['USERTYPE'];
 if($superAdmin=='A')
 {
	 //1st layer collection data 
 $query="set dateformat dmy  select SUM(recamount) as RecAmount,Acnumb ,m.venturecd ,v.VentureName,m.BranchCd,b.BranchName
 from master.MemberReceipts as m left join master.Venture as v 
 on  m.venturecd=v.venturecd left join master.Branch as b on m.BranchCd=b.BranchCd 
 where cast(m.CreatedOn   as date)= '$curr_timestamp' and (Acnumb between 300 and 499 or Acnumb = 1000) group by 
 Acnumb,m.venturecd,VentureName,m.BranchCd,b.BranchName order by m.venturecd,m.BranchCd;";
   //2nd layer collection data
 $l2_query=" set dateformat dmy select SUM(recamount) as RecAmount,Acnumb ,m.venturecd ,v.VentureName,m.BranchCd,b.BranchName 
 from master.TempRecData as m left join master.Venture as v on  m.venturecd=v.venturecd left join master.Branch as b on m.BranchCd=b.BranchCd
 where cast(m.CreatedOn   as date)= '$curr_timestamp' group by Acnumb,m.venturecd,VentureName,m.BranchCd,b.BranchName   order by m.venturecd;";
 	 
 $l2_exequery=sqlsrv_query($conn,$l2_query);
 $exequery=sqlsrv_query($conn,$query);
 
 while ($row=sqlsrv_fetch_object($exequery)){
  $data[]=$row; 
 } 
 while ($l2_row=sqlsrv_fetch_object($l2_exequery)){ 
  $data[]=$l2_row;		
 }	
 }
 else
 {
	 $row = array('USERTYPE' => 'R');
	 $data[]=$row;
 }
 
 echo json_encode($data); 
 
?>