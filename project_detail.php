<!DOCTYPE html>
<html>
<head>
	<?php
	include('head.php');
	?>
</head>
<body>
	<?php
	include('conn.php');
	include('navbar.php');
	$p_id = $_GET['id'];
	$qproject = "SELECT * FROM project WHERE p_id = '$p_id';";
	$qprojectrun = mysqli_query($conn,$qproject);
	$result = mysqli_fetch_assoc($qprojectrun);
	?>
	<div style="padding: 2rem;">
		<?php
		if (isset($_GET['flag'])) {
			$flag = $_GET['flag'];
			if ($flag == 1) {
				?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Data has been updated!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
		}
		?>
		<div class="row align-items-end">
			<div class="col">
				<h2><?php echo $result['p_name']; ?></h2>
				<h5><?php echo $result['job_code']; ?></h5>
			</div>
			<div id="buttons" style="padding-right: 1rem;">
				<button type="button" class="btn btn-primary" onclick="window.open('project_print.php?id=<?php echo $result['p_id']; ?>', 'detail_project', 'scrollbars');"><span><i class="fa fa-print"></i></span> Print</button>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#editproject"><span><i class="fa fa-pencil"></i></span> Edit</button>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><span><i class="fa fa-trash"></i></span> Delete</button>
			</div>
		</div>
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
	<div class="modal fade" tabindex="-1" id="deleteModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Warning!</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="project_delete.php" enctype="multipart/form-data">
				<input class="form-control" name="p_id" value="<?php echo $p_id; ?>" hidden="">
					<div class="modal-body">
						<p>
							This project might be discussed at some meeting<br>
							Are you sure want to <strong>delete</strong> this data?
						</p>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" id="del_meeting" name="del_meeting" type="checkbox" onchange="del_meet()">
								<label class="custom-control-label" for="del_meeting">Delete meeting that discusses this project</label>
							</div>
							<small id="del_meeting_warning" style="display: none;"><strong style="color: red;">WARNING!</strong> All meeting that discuss this project will be deleted</small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="del_project" value="del_project" class="btn btn-primary">Yes</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" id="editproject">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Project Data</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form method="post" action="project_edit.php" enctype="multipart/form-data">
				<input class="form-control" name="p_id" value="<?php echo $p_id; ?>" hidden="">
					<div class="modal-body">
						<div class="form-group">
							<label for="p_name_form"><strong>Project Name</strong></label>
							<input class="form-control" required="" name="p_name" id="p_name_form" value="<?php echo $result['p_name']; ?>">
						</div>
						<div class="form-group">
							<label><strong>Job Code</strong></label>
							<div class="row" style="margin-left: 1px; margin-right: 1px;">
								<input required="" class="form-control" style="width: 8%; text-align: center;" id="job_code1" type="text" pattern="[0-9]{1}" title="One-digit number" maxlength="1" name="job_code1" value="<?php echo substr($result['job_code'], 0, 1); ?>">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 20%; text-align: center;" id="job_code2" type="text" pattern="[0-9]{4}" title="Four-digit number" maxlength="4" name="job_code2" value="<?php echo substr($result['job_code'], 2, 4); ?>">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 16%; text-align: center;" id="job_code3" type="text" pattern="[0-9]{2}" title="Two-digit number" maxlength="2" name="job_code3" value="<?php echo substr($result['job_code'], 7, 2); ?>">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 20%; text-align: center;" id="job_code4" type="text" pattern="[0-9]{4}" title="Four-digit number" maxlength="4" name="job_code4" value="<?php echo substr($result['job_code'], 10); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="client_form"><strong>Client</strong></label>
							<input class="form-control" name="client" id="client_form" value="<?php echo $result['client']; ?>">
						</div>
						<div class="form-group">
							<label for="location_form"><strong>Location</strong></label>
							<textarea class="form-control" id="location_form" rows="3" name="location"><?php echo $result['location']; ?></textarea>
						</div>
						<div class="form-group">
							<strong>Schedule</strong>
							<div class="row">
								<div class="col">
									<label for="start_form">Start</label>
									<input class="form-control" name="schedule_start" id="start_form" type="date" value="<?php echo $result['schedule_start']; ?>">
								</div>
								<div class="col">
									<label for="finish_form">Finish</label>
									<input class="form-control" name="schedule_finish" id="finish_form" type="date" value="<?php echo $result['schedule_finish']; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="work_scope_form"><strong>Scope of Work</strong></label>
							<textarea class="form-control" id="work_scope_form" rows="3" name="work_scope"><?php echo $result['work_scope']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="budget_form"><strong>Budget</strong></label>
							<input class="form-control" name="budget" id="budget_form" value="<?php echo $result['budget']; ?>">
						</div>
						<div class="form-group">
							<label for="financial_form"><strong>Financial</strong></label>
							<input class="form-control" name="financial" id="financial_form" value="<?php echo $result['financial']; ?>">
						</div>
						<div class="form-group">
							<label for="main_work_form"><strong>Main Work</strong></label>
							<textarea class="form-control" id="main_work_form" rows="3" name="main_work"><?php echo $result['main_work']; ?></textarea>
						</div>
						<div class="form-group">
							<strong>Client Reliability</strong>
							<ul style="padding-left: 1rem;">
								<li>
									<label for="political_risk">Political Risk</label>
									<textarea class="form-control" id="political_risk" rows="3" name="political_risk"><?php echo $result['political_risk']; ?></textarea>
								</li>
								<li>
									<label for="client_financial_risk">Client Financial Risk</label>
									<textarea class="form-control" id="client_financial_risk" rows="3" name="client_financial_risk"><?php echo $result['client_financial_risk']; ?></textarea>
								</li>
								<li>
									<label for="other_client_risk">Other Client Risk</label>
									<textarea class="form-control" id="other_client_risk" rows="3" name="other_client_risk"><?php echo $result['other_client_risk']; ?></textarea>
								</li>
							</ul>
						</div>
						<div class="form-group">
							<label for="cash_flow_r_risk"><strong>Cash Flow Reliability Risk</strong></label>
							<textarea class="form-control" id="cash_flow_r_risk" rows="3" name="cash_flow_r_risk"><?php echo $result['cash_flow_r_risk']; ?></textarea>
						</div>
						<div class="form-group">
							<strong>Guarantee Risk</strong>
							<ul style="padding-left: 1rem;">
								<li>
									<label for="process_guarantee_risk">Process Guarantee Risk</label>
									<textarea class="form-control" id="process_guarantee_risk" rows="3" name="process_guarantee_risk"><?php echo $result['process_guarantee_risk']; ?></textarea>
								</li>
								<li>
									<label for="tech_guarantee_risk">Technical Guarantee Risk</label>
									<textarea class="form-control" id="tech_guarantee_risk" rows="3" name="tech_guarantee_risk"><?php echo $result['tech_guarantee_risk']; ?></textarea>
								</li>
								<li>
									<label for="other_guarantee_risk">Other Guarantee Risk</label>
									<textarea class="form-control" id="other_guarantee_risk" rows="3" name="other_guarantee_risk"><?php echo $result['other_guarantee_risk']; ?></textarea>
								</li>
							</ul>
						</div>
						<div class="form-group">
							<label for="profitable_analysis"><strong>Profitabililty Analysis</strong></label>
							<textarea class="form-control" id="profitable_analysis" rows="3" name="profitable_analysis"><?php echo $result['profitable_analysis']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="competitors_analysis"><strong>Competitors Analysis</strong></label>
							<textarea class="form-control" id="competitors_analysis" rows="3" name="competitors_analysis"><?php echo $result['competitors_analysis']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="marketing_strategy"><strong>Marketing Strategy</strong></label>
							<textarea class="form-control" id="marketing_strategy" rows="3" name="marketing_strategy"><?php echo $result['marketing_strategy']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="future_opportunity"><strong>Future Opportunity</strong></label>
							<textarea class="form-control" id="future_opportunity" rows="3" name="future_opportunity"><?php echo $result['future_opportunity']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="capability_analysis"><strong>Capability Analysis</strong></label>
							<textarea class="form-control" id="capability_analysis" rows="3" name="capability_analysis"><?php echo $result['capability_analysis']; ?></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="edit_project" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
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
		$(document).ready(function(){
			document.getElementById("del_meeting").checked = false;
		});
		function del_meet(){
			var checkBox = document.getElementById("del_meeting");
			if (checkBox.checked == true) {
				document.getElementById("del_meeting_warning").style.display = "block";
			} else {
				document.getElementById("del_meeting_warning").style.display = "none";
			}
		}
	</script>
	<?php
	mysqli_close($conn);
	?>
</body>
</html>