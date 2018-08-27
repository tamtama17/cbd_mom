<!DOCTYPE html>
<html>
<head>
	<?php
	include('head.php');
	?>
	<style type="text/css">
		body {
			color: black;
		}
	</style>
</head>
<body>
	<?php
	include('conn.php');
	$p_id = $_GET['id'];
	$qproject = "SELECT * FROM project WHERE p_id = '$p_id';";
	$qprojectrun = mysqli_query($conn,$qproject);
	$result = mysqli_fetch_assoc($qprojectrun);
	?>
	<div style="padding: 2rem;">
		<h2><?php echo $result['p_name']; ?></h2>
		<h5><?php echo $result['job_code']; ?></h5>
		<hr class="my-4">
		<table>
			<tbody>
				<tr>
					<th width="12%"><strong>Client</strong></th>
					<td>
						<?php echo $result['client']; ?>
					</td>
				</tr>
				<tr>
					<th><strong>Location</strong></th>
					<td>
						<?php echo $result['location']; ?>
					</td>
				</tr>
				<tr>
					<th rowspan="2"><strong>Schedule</strong></th>
					<td>
						<div class="row">
							<div class="col-1">
								Start
							</div>:
							<div class="col">
								<?php
								if ($result['schedule_start'] == '' || $result['schedule_start'] == NULL || $result['schedule_start'] == '0000-00-00') {
									echo "-";
								}
								else {
									echo date("l, F jS Y", strtotime($result['schedule_start']));
								}
								?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-1">
								Finish
							</div>:
							<div class="col">
								<?php
								if ($result['schedule_finish'] == '' || $result['schedule_finish'] == NULL || $result['schedule_finish'] == '0000-00-00') {
									echo "-";
								}
								else {
									echo date("l, F jS Y", strtotime($result['schedule_finish']));
								}
								?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th><strong>Scope of Work</strong></th>
					<td>
						<?php echo $result['work_scope']; ?>
					</td>
				</tr>
				<tr>
					<th><strong>Budget</strong></th>
					<td>
						<?php echo $result['budget']; ?>
					</td>
				</tr>
				<tr>
					<th><strong>Financial</strong></th>
					<td>
						<?php echo $result['financial']; ?>
					</td>
				</tr>
				<tr>
					<th><strong>Main Work</strong></th>
					<td>
						<?php echo $result['main_work']; ?>
					</td>
				</tr>
				<tr>
					<th colspan="2"><strong>Client Reliability</strong></th>
				</tr>
				<tr>
					<td colspan="2">
						<ul>
							<li>
								Political Risk<br>
								<?php if ($result['political_risk'] == '' || $result['political_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['political_risk']; ?>
							</li>
							<li>
								Client Financial Risk<br>
								<?php if ($result['client_financial_risk'] == '' || $result['client_financial_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['client_financial_risk']; ?>
							</li>
							<li>
								Other Risk<br>
								<?php if ($result['other_client_risk'] == '' || $result['other_client_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['other_client_risk']; ?>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Cash Flow Reliability Risk</strong><br>
						<?php if ($result['cash_flow_r_risk'] == '' || $result['cash_flow_r_risk'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['cash_flow_r_risk']; ?>
					</td>
				</tr>
				<tr>
					<th colspan="2"><strong>Guarantee Risk</strong></th>
				</tr>
				<tr>
					<td colspan="2">
						<ul>
							<li>
								Process Guarantee Risk<br>
								<?php if ($result['process_guarantee_risk'] == '' || $result['process_guarantee_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['process_guarantee_risk']; ?>
							</li>
							<li>
								Technical Guarantee Risk<br>
								<?php if ($result['tech_guarantee_risk'] == '' || $result['tech_guarantee_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['tech_guarantee_risk']; ?>
							</li>
							<li>
								Other Guarantee Risk<br>
								<?php if ($result['other_guarantee_risk'] == '' || $result['other_guarantee_risk'] == NULL) {
									echo "<strong style='color: red;'>No Data</strong>";
								} echo $result['other_guarantee_risk']; ?>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Profitability Analysis</strong><br>
						<?php if ($result['profitable_analysis'] == '' || $result['profitable_analysis'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['profitable_analysis']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Competitiors Analysis</strong><br>
						<?php if ($result['competitors_analysis'] == '' || $result['competitors_analysis'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['competitors_analysis']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Marketing Strategy</strong><br>
						<?php if ($result['marketing_strategy'] == '' || $result['marketing_strategy'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['marketing_strategy']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Future Oportunity</strong><br>
						<?php if ($result['future_opportunity'] == '' || $result['future_opportunity'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['future_opportunity']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Capability Analysis</strong><br>
						<?php if ($result['capability_analysis'] == '' || $result['capability_analysis'] == NULL) {
							echo "<strong style='color: red;'>No Data</strong>";
						} echo $result['capability_analysis']; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<style type="text/css">
		table {
			width:100%;
			max-width:100%;
			margin-bottom:1rem;
			border-collapse: collapse;
		}
		table, th, td {
			border: 1px solid black;
		}
		th,td{
			padding: 1rem;
		}
	</style>
	<script type="text/javascript">
		$( document ).ready(function() {
			window.print();
		});
	</script>
	<?php
	mysqli_close($conn);
	?>
</body>
</html>