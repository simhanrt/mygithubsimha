<?php
  include "db.php";
  
  $ApiKey=$_GET['ApiKey'];
  $Prikey = implode('-', str_split(substr(strtolower($ApiKey), 0, 32), 6));
  $data=array();
  $d_v_a_p=array();
  $d_v_m_p=array();
  $d_v_a_b=array();
  $d_v_m_b=array();
  $d_v_a_c=array();
  $d_v_m_c=array();
  
  $curr_timestamp = date('d-m-Y');
  
  $superquery="select USERTYPE from dbo.USERS where Apikey='$Prikey';";
  $superexe=sqlsrv_query($conn,$superquery);
  $values=sqlsrv_fetch_array($superexe,SQLSRV_FETCH_ASSOC);
  $superAdmin=$values['USERTYPE'];
  if($superAdmin=='A')
  {
	$venture_agent_payments="set dateformat DMY select VENTURECD,SUM(Amount) as Pym_V_A_Total from master.LedgerMaster where PaymentDate='15-11-2018' and AmtType='D' AND AccType IN ('APY') AND (Vcode BETWEEN 300 And 400 OR VCode=1000) GROUP BY VentureCd order by VentureCd;";
	$venture_member_payments="set dateformat DMY select SUM(Amount) as Pym_V_M_Total,VENTURECD from master.LedgerMaster where PaymentDate='15-11-2018' and AmtType='D' AND AccType IN ('MPY') AND (Vcode BETWEEN 300 And 400 OR VCode=1000) GROUP BY VentureCd order by VentureCd;";
	$venture_agent_bank="set dateformat DMY select SUM(Amount) as Pym_B_A_Total,VENTURECD from master.LedgerMaster where PaymentDate='15-11-2018' and AmtType='D' AND AccType IN ('APY') AND (Vcode BETWEEN 300 And 400) GROUP BY VentureCd order by VentureCd;";
	$venture_member_bank="set dateformat DMY select SUM(Amount) as Pym_B_M_Total,VENTURECD from master.LedgerMaster where PaymentDate='15-11-2018' and AmtType='D' AND AccType IN ('MPY') AND (Vcode BETWEEN 300 And 400) GROUP BY VentureCd order by VentureCd;";
	$venture_agent_cash="set dateformat DMY select SUM(Amount) as Pym_C_A_Total,VENTURECD from master.LedgerMaster where AmtType='D' AND AccType IN ('APY') AND Vcode=1000 and PaymentDate='15-11-2018' GROUP BY VentureCd order by VentureCd;";
	$venture_member_cash="set dateformat DMY select SUM(Amount) as Pym_C_M_Total,VENTURECD from master.LedgerMaster where AmtType='D' AND AccType IN ('MPY') AND Vcode=1000 and PaymentDate='15-11-2018' GROUP BY VentureCd order by VentureCd;";
	$exe_v_a_p=sqlsrv_query($conn,$venture_agent_payments);
	$exe_v_m_p=sqlsrv_query($conn,$venture_member_payments);
	$exe_v_a_b=sqlsrv_query($conn,$venture_agent_bank);
	$exe_v_m_b=sqlsrv_query($conn,$venture_member_bank);
	$exe_v_a_c=sqlsrv_query($conn,$venture_agent_cash);
	$exe_v_m_c=sqlsrv_query($conn,$venture_member_cash);
	while($v_a_p=sqlsrv_fetch_object($exe_v_a_p))
	{
		$v_m_p=sqlsrv_fetch_object($exe_v_m_p);
		$v_a_b=sqlsrv_fetch_object($exe_v_a_b);
		$v_m_b=sqlsrv_fetch_object($exe_v_m_b);
		$v_a_c=sqlsrv_fetch_object($exe_v_a_c);
		$v_m_c=sqlsrv_fetch_object($exe_v_m_c);
		if($v_m_p)
		 $v_a_p->member_payment=$v_m_p->Pym_V_M_Total;
		else
		 $v_a_p->member_payment='0.0';
	    if($v_a_b)
		 $v_a_p->agent_bank=$v_a_b->Pym_B_A_Total;
	    else
		 $v_a_p->agent_bank='0.0';	
	    if($v_m_b)
		 $v_a_p->member_bank=$v_m_b->Pym_B_M_Total;
	    else
		 $v_a_p->member_bank='0.0';	
	    if($v_a_c)
		 $v_a_p->agent_cash=$v_a_c->Pym_C_A_Total;
	    else
		 $v_a_p->agent_cash='0.0';	
	    if($v_m_c)
		 $v_a_p->member_cash=$v_m_c->Pym_C_M_Total;
	    else
		 $v_a_p->member_cash='0.0';	
		$d_v_a_p[]=$v_a_p;
	}
	echo json_encode($d_v_a_p);
  }
  else
  {
	 $row = array('USERTYPE' => 'R');
	 $data[]=$row;
  }
 
 // echo json_encode($data); 
  
?>