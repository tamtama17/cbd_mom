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
	?>
	<div style="padding: 2rem;">
		<?php
		if (isset($_GET['flag'])) {
			$flag = $_GET['flag'];
			if ($flag == 1) {
				?>
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
					<strong>Success!</strong> New data has been added!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
			if ($flag == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Data has been deleted!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
			if ($flag == 3) {
				?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Project datas has been added!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
			if ($flag == 4) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Failed!</strong> No data added! Please check your excel.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
			if ($flag == 5) {
				?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Warning!</strong> Some data not added! Please check your excel.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php
			}
		}
		?>
		<div class="row align-items-end">
			<div class="col">
				<h2 id="judul">Meeting Record</h2>
			</div>
			<div id="buttons" style="padding-right: 1rem;">
				<button id="topic_btn" type="button" class="btn btn-primary" onclick="changetotopic()" style="border-radius: 5px; padding: 5px 10px;" >Project List</button>
				<button id="meeting_btn" type="button" class="btn btn-primary" onclick="changetomeeting()" style="border-radius: 5px; padding: 5px 10px; display: none;" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Meeting Record</button>
			</div>
		</div>
		<hr class="my-4">
		<div id="meetingTable">
			<button type="button" class="btn btn-primary" style="float: left;" data-toggle="modal" data-target="#newmeetingModal"><span><i class="fa fa-plus"></i></span> New Meeting</button>
			<table class="table table-hover table-bordered table-sm shadow-sm" id="ml_Table">
				<thead class="thead-dark">
					<tr>
						<th width="18%" scope="col">Date</th>
						<th width="32%" scope="col">Meeting Type</th>
						<th width="25%" scope="col">Project</th>
						<th width="25%" scope="col">Topic</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$qselect = "SELECT * FROM meeting m LEFT JOIN m_type mt USING(mt_id) ORDER BY meeting_date DESC;";
					$qrun = mysqli_query($conn,$qselect);
					while ($result = mysqli_fetch_assoc($qrun)) {
						$meeting_id = $result['meeting_id'];
					?>
					<tr style="cursor: pointer;" onclick="window.location.href = 'meeting_detail.php?id=<?php echo $result['meeting_id']; ?>';">
						<td><?php echo substr($result['meeting_date'], 0, 10); ?></td>
						<td><?php echo $result['mt_name']; ?></td>
						<td>
							<?php
							$qproject = "SELECT DISTINCT p.* FROM project p JOIN mtp_relation rel USING(p_id) WHERE meeting_id = '$meeting_id';";
							$qprojectr = mysqli_query($conn,$qproject);
							while ($project_list = mysqli_fetch_assoc($qprojectr)) {
								echo $project_list['p_name']."<br>";
							}
							?>
						</td>
						<td>
							<?php
							$qtopic = "SELECT DISTINCT t.* FROM topic t JOIN mtp_relation rel USING(topic_id) WHERE meeting_id = '$meeting_id';";
							$qtopicr = mysqli_query($conn,$qtopic);
							while ($topic_list = mysqli_fetch_assoc($qtopicr)) {
								echo $topic_list['topic_name']."<br>";
							}
							?>
						</td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>

		<div id="projectTable" style="display: none;">
			<button type="button" class="btn btn-primary" style="float: left;" data-toggle="modal" data-target="#newproject"><span><i class="fa fa-plus"></i></span> New Project</button>
			<button type="button" class="btn btn-success" style="float: left; margin-left: 0.5rem;" data-toggle="modal" data-target="#importModal"><span><i class="fa fa-upload"></i></span> Import</button>
				<button type="button" class="btn btn-primary" style="float: left; margin-left: 0.5rem;" onclick="window.open('project_list_print.php', 'detail_project', 'scrollbars');"><span><i class="fa fa-print"></i></span> Print</button>
			<table class="table table-hover table-bordered table-sm shadow-sm" id="tl_Table">
				<thead class="thead-dark">
					<tr>
						<th width="10%">Job Code</th>
						<th>Project</th>
						<th>Client</th>
						<th>Location</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$qselect = "SELECT * FROM project;";
					$qrun = mysqli_query($conn,$qselect);
					while ($result = mysqli_fetch_assoc($qrun)) {
					?>
					<tr style="cursor: pointer;" onclick="window.location.href = 'project_detail.php?id=<?php echo $result['p_id']; ?>';">
						<td><?php echo $result['job_code']; ?></td>
						<td><?php echo $result['p_name']; ?></td>
						<td><?php echo $result['client']; ?></td>
						<td><?php echo $result['location']; ?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" id="importModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Import from Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="project_import.php" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<strong>Download template file, fill with project data, then submit the file.</strong><br><br>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" id="fileImport" name="fileExcel" class="custom-file-input" accept="application/vnd.ms-excel">
									<label class="custom-file-label" for="fileImport">Choose file</label>
								</div>
							</div>
							<a href="assets/project_detail_template.xls" download="">Downlaod template file</a>
							<small id="fileHelp" class="form-text text-muted" style="float: right;">File must be .xls (Excel 97-2003)</small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="importData" value="importData" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" tabindex="-1" id="newmeetingModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Select Meeting Type</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form method="get" action="new_meeting.php" enctype="multipart/form-data">
					<div class="modal-body">
						<div id="existingData">
							<div class="form-group">
								<label for="mtSelect"><h5>Meeting Type</h5></label>
								<div class="row">
									<div class="col">
										<select onchange="gantitipe(this.value)" class="form-control custom-select" id="mtSelect" name="mt_id" required="">
											<option value="" selected="">Choose meeting type</option>
											<?php
											$qmt = "SELECT * FROM m_type;";
											$qmtrun = mysqli_query($conn,$qmt);
											while ($mt = mysqli_fetch_assoc($qmtrun)) {
											?>
												<option value='<?php echo $mt['mt_id']; ?>'><?php echo $mt['mt_name']; ?></option>
											<?php
												}
											?>
										</select>
										<small id="topicHelp" class="form-text text-muted">If meeting type doesn't exist, click '<span><i class="fa fa-plus"></i></span> New' button to create new</small>
									</div>
									<div style="margin-right: 1rem;">
										<button type="button" onclick="newMT()" class="btn btn-primary"><span><i class="fa fa-plus"></i></span> New</button>
									</div>
								</div>
							</div>
						</div>
						<div id="newData" style="display: none;">
							<div class="form-group">
								<label for="mt_name_from"><h5>Meeting Type</h5></label>
								<div class="row">
									<div class="col">
										<input class="form-control" name="mt_name" id="mt_name_from">
										<small id="comHelp" class="form-text text-muted">Click '<span><i class="fa fa-times"></i></span> Cancel' button to select from existing meeting type</small>
									</div>
									<div style="margin-right: 1rem;">
										<button type="button" onclick="newMTCancel()" class="btn btn-danger"><span><i class="fa fa-times"></i></span> Cancel</button>
									</div>
								</div>
							</div>
						</div>
						<div id="selectProject" style="display: none;">
							<div class="form-group">
								<label for="mtSelect"><h5>Project</h5></label>
								<select class="form-control custom-select" id="projectSelect" name="p_id">
									<option value="" selected="">Choose project</option>
									<?php
									$qallproject = "SELECT * FROM project;";
									$qallprojectr = mysqli_query($conn,$qallproject);
									while ($all_project = mysqli_fetch_assoc($qallprojectr)) {
									?>
										<option value='<?php echo $all_project['p_id']; ?>'><?php echo $all_project['p_name']; ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="m_typenya" value="submited" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" tabindex="-1" id="newproject">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Project Data</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form method="post" action="input_project.php" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label for="p_name_form"><strong>Project Name</strong></label>
							<input class="form-control" required="" name="p_name" id="p_name_form">
						</div>
						<div class="form-group">
							<label><strong>Job Code</strong></label>
							<div class="row" style="margin-left: 1px; margin-right: 1px;">
								<input required="" class="form-control" style="width: 8%; text-align: center;" id="job_code1" type="text" pattern="[0-9]{1}" title="One-digit number" maxlength="1" name="job_code1">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 20%; text-align: center;" id="job_code2" type="text" pattern="[0-9]{4}" title="One-digit number" maxlength="4" name="job_code2">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 16%; text-align: center;" id="job_code3" type="text" pattern="[0-9]{2}" title="One-digit number" maxlength="2" name="job_code3">
								<span style="width: 12%;"><center>_</center></span>
								<input required="" class="form-control" style="width: 20%; text-align: center;" id="job_code4" type="text" pattern="[0-9]{4}" title="One-digit number" maxlength="4" name="job_code4">
							</div>
						</div>
						<div class="form-group">
							<label for="client_form"><strong>Client</strong></label>
							<input class="form-control" name="client" id="client_form">
						</div>
						<div class="form-group">
							<label for="location_form"><strong>Location</strong></label>
							<textarea class="form-control" id="location_form" rows="3" name="location"></textarea>
						</div>
						<div class="form-group">
							<strong>Schedule</strong>
							<div class="row">
								<div class="col">
									<label for="start_form">Start</label>
									<input class="form-control" name="schedule_start" id="start_form" type="date">
								</div>
								<div class="col">
									<label for="finish_form">Finish</label>
									<input class="form-control" name="schedule_finish" id="finish_form" type="date">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="work_scope_form"><strong>Scope of Work</strong></label>
							<textarea class="form-control" id="work_scope_form" rows="3" name="work_scope"></textarea>
						</div>
						<div class="form-group">
							<label for="budget_form"><strong>Budget</strong></label>
							<input class="form-control" name="budget" id="budget_form">
						</div>
						<div class="form-group">
							<label for="financial_form"><strong>Financial</strong></label>
							<input class="form-control" name="financial" id="financial_form">
						</div>
						<div class="form-group">
							<label for="main_work_form"><strong>Main Work</strong></label>
							<textarea class="form-control" id="main_work_form" rows="3" name="main_work"></textarea>
						</div>
						<div class="form-group">
							<strong>Client Reliability</strong>
							<ul style="padding-left: 1rem;">
								<li>
									<label for="political_risk">Political Risk</label>
									<textarea class="form-control" id="political_risk" rows="3" name="political_risk"></textarea>
								</li>
								<li>
									<label for="client_financial_risk">Client Financial Risk</label>
									<textarea class="form-control" id="client_financial_risk" rows="3" name="client_financial_risk"></textarea>
								</li>
								<li>
									<label for="other_client_risk">Other Client Risk</label>
									<textarea class="form-control" id="other_client_risk" rows="3" name="other_client_risk"></textarea>
								</li>
							</ul>
						</div>
						<div class="form-group">
							<label for="cash_flow_r_risk"><strong>Cash Flow Reliability Risk</strong></label>
							<textarea class="form-control" id="cash_flow_r_risk" rows="3" name="cash_flow_r_risk"></textarea>
						</div>
						<div class="form-group">
							<strong>Guarantee Risk</strong>
							<ul style="padding-left: 1rem;">
								<li>
									<label for="process_guarantee_risk">Process Guarantee Risk</label>
									<textarea class="form-control" id="process_guarantee_risk" rows="3" name="process_guarantee_risk"></textarea>
								</li>
								<li>
									<label for="tech_guarantee_risk">Technical Guarantee Risk</label>
									<textarea class="form-control" id="tech_guarantee_risk" rows="3" name="tech_guarantee_risk"></textarea>
								</li>
								<li>
									<label for="other_guarantee_risk">Other Guarantee Risk</label>
									<textarea class="form-control" id="other_guarantee_risk" rows="3" name="other_guarantee_risk"></textarea>
								</li>
							</ul>
						</div>
						<div class="form-group">
							<label for="profitable_analysis"><strong>Profitabililty Analysis</strong></label>
							<textarea class="form-control" id="profitable_analysis" rows="3" name="profitable_analysis"></textarea>
						</div>
						<div class="form-group">
							<label for="competitors_analysis"><strong>Competitors Analysis</strong></label>
							<textarea class="form-control" id="competitors_analysis" rows="3" name="competitors_analysis"></textarea>
						</div>
						<div class="form-group">
							<label for="marketing_strategy"><strong>Marketing Strategy</strong></label>
							<textarea class="form-control" id="marketing_strategy" rows="3" name="marketing_strategy"></textarea>
						</div>
						<div class="form-group">
							<label for="future_opportunity"><strong>Future Opportunity</strong></label>
							<textarea class="form-control" id="future_opportunity" rows="3" name="future_opportunity"></textarea>
						</div>
						<div class="form-group">
							<label for="capability_analysis"><strong>Capability Analysis</strong></label>
							<textarea class="form-control" id="capability_analysis" rows="3" name="capability_analysis"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="newproject" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<style type="text/css">
		th{
			text-align: center;
		}
	</style>

	<script>
	$(document).ready( function () {
		$('#ml_Table').DataTable({
			<?php if (isset($_GET['key'])) {
			?>
			"oSearch": {"sSearch": "<?php echo $_GET['key'];?>"},
			<?php
			} ?>
			"lengthChange": false,
			"pageLength": 25,
			"order": [[0, "desc"]]
		});
	} );

	$(document).ready( function () {
		$('#tl_Table').DataTable({
			"lengthChange": false,
			"pageLength": 25
		});
	} );

	function changetotopic() {
		document.getElementById("meetingTable").style.display = "none";
		document.getElementById("projectTable").style.display = "block";
		document.getElementById("topic_btn").style.display = "none";
		document.getElementById("meeting_btn").style.display = "block";
		document.getElementById("judul").innerHTML = "Project List";
	}
	function changetomeeting() {
		document.getElementById("meetingTable").style.display = "block";
		document.getElementById("projectTable").style.display = "none";
		document.getElementById("topic_btn").style.display = "block";
		document.getElementById("meeting_btn").style.display = "none";
		document.getElementById("judul").innerHTML = "Meeting Record";
	}


	function gantitipe(mt_id) {
		if (mt_id == 3) {
			document.getElementById("selectProject").style.display = "block";
			document.getElementById("projectSelect").required = true;
		} else {
			document.getElementById("selectProject").style.display = "none";
			document.getElementById("projectSelect").required = false;
			document.getElementById("projectSelect").value = '';
		}
	}

	function newMT() {
		document.getElementById("newData").style.display = "block";
		document.getElementById("existingData").style.display = "none";
		document.getElementById('mtSelect').value = '';
		document.getElementById("mtSelect").required = false;
		document.getElementById("mt_name_from").required = true;
	}
	function newMTCancel() {
		document.getElementById("newData").style.display = "none";
		document.getElementById("existingData").style.display = "block";
		document.getElementById('mt_name_from').value = '';
		document.getElementById("mt_name_from").required = false;
		document.getElementById("mtSelect").required = true;
	}
	</script>

	<?php
	mysqli_close($conn);
	?>
</body>
</html>