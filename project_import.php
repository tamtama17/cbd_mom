<?php
include('conn.php');
require('excel_reader.php');

if (isset($_POST['importData'])) {
	$berhasil = 0;
	$total = 0;
	$target = basename($_FILES["fileExcel"]["name"]);
	move_uploaded_file($_FILES["fileExcel"]["tmp_name"], $target);

	$data = new Spreadsheet_Excel_Reader($_FILES["fileExcel"]["name"], false);

	$baris = $data->rowcount($sheet_index=0);

	for ($i=3; $i<=$baris ; $i++) {
		$total++;
		$p_name = $data->val($i, 1);
		$job_code = $data->val($i, 2);

		$qcekdata = "SELECT p_id FROM project WHERE job_code = '$job_code'";
		$cekdatarun = mysqli_query($conn,$qcekdata);
		$jumlah = mysqli_num_rows ($cekdatarun);
		if ($jumlah == 0) {
			$client = $data->val($i, 3);
			$location = $data->val($i, 4);
			$schedule_start = $data->val($i, 5);
			$schedule_finish = $data->val($i, 6);
			$work_scope = $data->val($i, 7);
			$budget = $data->val($i, 8);
			$financial = $data->val($i, 9);
			$main_work = $data->val($i, 10);
			$political_risk = $data->val($i, 11);
			$client_financial_risk = $data->val($i, 12);
			$other_client_risk = $data->val($i, 13);
			$cash_flow_r_risk = $data->val($i, 14);
			$process_guarantee_risk = $data->val($i, 15);
			$tech_guarantee_risk = $data->val($i, 16);
			$other_guarantee_risk = $data->val($i, 17);
			$profitable_analysis = $data->val($i, 18);
			$competitors_analysis = $data->val($i, 19);
			$marketing_strategy = $data->val($i, 20);
			$future_opportunity = $data->val($i, 21);
			$capability_analysis = $data->val($i, 22);

			$qinsproject = "INSERT INTO project(p_name, job_code, client, location, schedule_start, schedule_finish, work_scope, budget, financial, main_work, political_risk, client_financial_risk, other_client_risk, cash_flow_r_risk, process_guarantee_risk, tech_guarantee_risk, other_guarantee_risk, profitable_analysis, competitors_analysis, marketing_strategy, future_opportunity, capability_analysis) VALUES ('$p_name', '$job_code', '$client', '$location', '$schedule_start', '$schedule_finish', '$work_scope', '$budget', '$financial', '$main_work', '$political_risk', '$client_financial_risk', '$other_client_risk', '$cash_flow_r_risk', '$process_guarantee_risk', '$tech_guarantee_risk', '$other_guarantee_risk', '$profitable_analysis', '$competitors_analysis', '$marketing_strategy', '$future_opportunity', '$capability_analysis')";
			if (mysqli_query($conn, $qinsproject)) {
				$berhasil++;
			} else {
				echo "query : ".$qinsproject."<br>";
				die("Error description: " . mysqli_error($conn));
			}
		}
	}
	
	if ($berhasil == $total && $total > 0) {
		header('location:./?flag=3');
	} else if($berhasil == 0) {
		header('location:./?flag=4');
	} else if($berhasil < $total) {
		header('location:./?flag=5');
	}

	unlink($_FILES["fileExcel"]["name"]);
	mysqli_close($conn);
}
?>