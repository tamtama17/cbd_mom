<?php
include('conn.php');
if (isset($_POST['newproject'])) {
	$p_name = $_POST['p_name'];
	echo "p_name : ".$p_name."<br>";

	$job_code1 = $_POST['job_code1'];
	$job_code2 = $_POST['job_code2'];
	$job_code3 = $_POST['job_code3'];
	$job_code4 = $_POST['job_code4'];
	$job_code = $job_code1."-".$job_code2."-".$job_code3."-".$job_code4;
	echo "jcnya : ".$job_code."<br>";

	$client = $_POST['client'];
	echo "client : ".$client."<br>";
	$location = $_POST['location'];
	echo "location : ".$location."<br>";
	$schedule_start = $_POST['schedule_start'];
	echo "schedule_start : ".$schedule_start."<br>";
	$schedule_finish = $_POST['schedule_finish'];
	echo "schedule_finish : ".$schedule_finish."<br>";
	$work_scope = $_POST['work_scope'];
	echo "work_scope : ".$work_scope."<br>";
	$budget = $_POST['budget'];
	echo "budget : ".$budget."<br>";
	$financial = $_POST['financial'];
	echo "financial : ".$financial."<br>";
	$main_work = $_POST['main_work'];
	echo "main_work : ".$main_work."<br>";
	$political_risk = $_POST['political_risk'];
	echo "political_risk : ".$political_risk."<br>";
	$client_financial_risk = $_POST['client_financial_risk'];
	echo "client_financial_risk : ".$client_financial_risk."<br>";
	$other_client_risk = $_POST['other_client_risk'];
	echo "other_client_risk : ".$other_client_risk."<br>";
	$cash_flow_r_risk = $_POST['cash_flow_r_risk'];
	echo "cash_flow_r_risk : ".$cash_flow_r_risk."<br>";
	$process_guarantee_risk = $_POST['process_guarantee_risk'];
	echo "process_guarantee_risk : ".$process_guarantee_risk."<br>";
	$tech_guarantee_risk = $_POST['tech_guarantee_risk'];
	echo "tech_guarantee_risk : ".$tech_guarantee_risk."<br>";
	$other_guarantee_risk = $_POST['other_guarantee_risk'];
	echo "other_guarantee_risk : ".$other_guarantee_risk."<br>";
	$profitable_analysis = $_POST['profitable_analysis'];
	echo "profitable_analysis : ".$profitable_analysis."<br>";
	$competitors_analysis = $_POST['competitors_analysis'];
	echo "competitors_analysis : ".$competitors_analysis."<br>";
	$marketing_strategy = $_POST['marketing_strategy'];
	echo "marketing_strategy : ".$marketing_strategy."<br>";
	$future_opportunity = $_POST['future_opportunity'];
	echo "future_opportunity : ".$future_opportunity."<br>";
	$capability_analysis = $_POST['capability_analysis'];
	echo "capability_analysis : ".$capability_analysis."<br>";

	$qinsproject = "INSERT INTO project(p_name, job_code, client, location, schedule_start, schedule_finish, work_scope, budget, financial, main_work, political_risk, client_financial_risk, other_client_risk, cash_flow_r_risk, process_guarantee_risk, tech_guarantee_risk, other_guarantee_risk, profitable_analysis, competitors_analysis, marketing_strategy, future_opportunity, capability_analysis) VALUES ('$p_name', '$job_code', '$client', '$location', '$schedule_start', '$schedule_finish', '$work_scope', '$budget', '$financial', '$main_work', '$political_risk', '$client_financial_risk', '$other_client_risk', '$cash_flow_r_risk', '$process_guarantee_risk', '$tech_guarantee_risk', '$other_guarantee_risk', '$profitable_analysis', '$competitors_analysis', '$marketing_strategy', '$future_opportunity', '$capability_analysis')";
	if (mysqli_query($conn, $qinsproject)) {
		header('location:./?flag=1');
	} else {
		die("Error description: " . mysqli_error($conn));
	}
	mysqli_close($conn);
}
?>