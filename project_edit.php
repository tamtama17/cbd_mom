<?php
include('conn.php');
if (isset($_POST['edit_project'])) {
	$p_id = $_POST['p_id'];
	echo "p_idnya : ".$p_id."<br>";

	$p_name = $_POST['p_name'];
	echo "mt_idnya : ".$p_name."<br>";

	$job_code1 = $_POST['job_code1'];
	$job_code2 = $_POST['job_code2'];
	$job_code3 = $_POST['job_code3'];
	$job_code4 = $_POST['job_code4'];
	$job_code = $job_code1."-".$job_code2."-".$job_code3."-".$job_code4;
	echo "jcnya : ".$job_code."<br>";

	$client = $_POST['client'];
	echo "mt_idnya : ".$client."<br>";
	$location = $_POST['location'];
	echo "mt_idnya : ".$location."<br>";
	$schedule_start = $_POST['schedule_start'];
	echo "mt_idnya : ".$schedule_start."<br>";
	$schedule_finish = $_POST['schedule_finish'];
	echo "mt_idnya : ".$schedule_finish."<br>";
	$work_scope = $_POST['work_scope'];
	echo "mt_idnya : ".$work_scope."<br>";
	$budget = $_POST['budget'];
	echo "mt_idnya : ".$budget."<br>";
	$financial = $_POST['financial'];
	echo "mt_idnya : ".$financial."<br>";
	$main_work = $_POST['main_work'];
	echo "mt_idnya : ".$main_work."<br>";
	$political_risk = $_POST['political_risk'];
	echo "mt_idnya : ".$political_risk."<br>";
	$client_financial_risk = $_POST['client_financial_risk'];
	echo "mt_idnya : ".$client_financial_risk."<br>";
	$other_client_risk = $_POST['other_client_risk'];
	echo "mt_idnya : ".$other_client_risk."<br>";
	$cash_flow_r_risk = $_POST['cash_flow_r_risk'];
	echo "mt_idnya : ".$cash_flow_r_risk."<br>";
	$process_guarantee_risk = $_POST['process_guarantee_risk'];
	echo "mt_idnya : ".$process_guarantee_risk."<br>";
	$tech_guarantee_risk = $_POST['tech_guarantee_risk'];
	echo "mt_idnya : ".$tech_guarantee_risk."<br>";
	$other_guarantee_risk = $_POST['other_guarantee_risk'];
	echo "mt_idnya : ".$other_guarantee_risk."<br>";
	$profitable_analysis = $_POST['profitable_analysis'];
	echo "mt_idnya : ".$profitable_analysis."<br>";
	$competitors_analysis = $_POST['competitors_analysis'];
	echo "mt_idnya : ".$competitors_analysis."<br>";
	$marketing_strategy = $_POST['marketing_strategy'];
	echo "mt_idnya : ".$marketing_strategy."<br>";
	$future_opportunity = $_POST['future_opportunity'];
	echo "mt_idnya : ".$future_opportunity."<br>";
	$capability_analysis = $_POST['capability_analysis'];
	echo "mt_idnya : ".$capability_analysis."<br>";

	$qupdateproject = "UPDATE project SET p_name='$p_name',job_code='$job_code',client='$client',location='$location',schedule_start='$schedule_start',schedule_finish='$schedule_finish',work_scope='$work_scope',budget='$budget',financial='$financial',main_work='$main_work',political_risk='$political_risk',client_financial_risk='$client_financial_risk',other_client_risk='$other_client_risk',cash_flow_r_risk='$cash_flow_r_risk',process_guarantee_risk='$process_guarantee_risk',tech_guarantee_risk='$tech_guarantee_risk',other_guarantee_risk='$other_guarantee_risk',profitable_analysis='$profitable_analysis',competitors_analysis='$competitors_analysis',marketing_strategy='$marketing_strategy',future_opportunity='$future_opportunity',capability_analysis='$capability_analysis' WHERE p_id = '$p_id'";
	if (mysqli_query($conn, $qupdateproject)) {
		header('location:project_detail.php?id='.$p_id.'&flag=1');
	} else {
		die("Error description: " . mysqli_error($conn));
	}
	mysqli_close($conn);
}
?>