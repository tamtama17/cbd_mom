<!DOCTYPE html>
<html>
<head>
	<?php
	include('head.php');
	?>
	<style type="text/css">
	[data-role="dynamic-fields"] > .attandees_form [data-role="add"] {
		display: none;
	}

	[data-role="dynamic-fields"] > .attandees_form:last-child [data-role="add"] {
		display: inline-block;
	}

	[data-role="dynamic-fields"] > .attandees_form:last-child [data-role="remove"] {
		display: none;
	}
	</style>
</head>
<body>
	<?php
	include('conn.php');
	include('navbar.php');
	$meeting_id = $_GET['id'];
	$qselect = "SELECT * FROM meeting JOIN m_type USING(mt_id) WHERE meeting_id='$meeting_id';";
	$qrun = mysqli_query($conn,$qselect);
	$result = mysqli_fetch_assoc($qrun);
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
				<h2><?php echo $result['mt_name']; ?></h2>
			</div>
			<div id="buttons" style="padding-right: 1rem;">
				<button type="button" class="btn btn-primary" onclick="window.open('meeting_print.php?meeting_id=<?php echo $meeting_id; ?>', 'detail_project', 'scrollbars');"><span><i class="fa fa-print"></i></span> Print</button>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal"><span><i class="fa fa-pencil"></i></span> Edit</button>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><span><i class="fa fa-trash"></i></span> Delete</button>
			</div>
		</div>
		<hr class="my-4">
		<table>
			<tbody>
				<tr>
					<td>
						<?php
						$m_date = date("F jS, Y", strtotime($result['meeting_date']));
						echo "DATE OF MEETING : ".$m_date;
						?>
					</td>
					<td>
						<?php
						if ($result['meeting_start'] != NULL) {
							$m_start = date("h:i A", strtotime($result['meeting_start']));
							$m_finish = date("h:i A", strtotime($result['meeting_finish']));
							echo "TIME : ".$m_start." - ".$m_finish;
						} else {
							$m_time = date("h:i A", strtotime($result['meeting_date']));
							echo "TIME : ".$m_time;
						}
						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						$m_venue = $result['meeting_venue'];
						echo "PLACE OF MEETING : ".$m_venue;
						?>
					</td>
					<td>
						<?php
						$minutes_by = $result['minutes_by'];
						echo "MINUTES BY : ".$minutes_by;
						?>
					</td>
				</tr>
				<tr>
					<?php
					if ($result['mt_id'] == 3) {
					$qproject = "SELECT DISTINCT p.* FROM project p JOIN mtp_relation rel USING(p_id) WHERE meeting_id = '$meeting_id';";
					$qprojectr = mysqli_query($conn,$qproject);
					$projectnya = mysqli_fetch_assoc($qprojectr);
					?>
					<td>
						<?php
						$m_name = $result['mt_name'];
						echo "SUBJECT : ";
						echo "<strong>".$m_name."</strong>";
						?>
					</td>
					<td>
						PROJECT NAME : <button type="button" class="btn btn-link" id="p_name_mt3" style="padding: 0; text-decoration: underline;" data-toggle="modal" data-target="#detailProject"><?php echo $projectnya['p_name']; ?></button>
					</td>
					<?php
					} else {
					?>
					<td colspan="2">
						<?php
						$m_name = $result['mt_name'];
						echo "SUBJECT : ";
						echo "<strong>".$m_name."</strong>";
						?>
					</td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;"><strong style="font-size: 18px;">DESCRIPTION OF DISCUSSION</strong></td>
				</tr>
				<?php
				if ($result['mt_id'] != 3) {
				?>
				<tr>
					<td colspan="2">
						<h5>Topic</h5>
						<?php
						$qtopic1 = "SELECT DISTINCT t.*, n.file_name FROM topic t JOIN mtp_relation rel USING(topic_id) JOIN notes n USING(notes_id) WHERE meeting_id = '$meeting_id';";
						$qtopicr1 = mysqli_query($conn,$qtopic1);
						echo "<ol>";
						while ($topic_list1 = mysqli_fetch_assoc($qtopicr1)) {
							echo "<li>".$topic_list1['topic_name']."</li>";
						}
						echo "</ol>";
						?>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2">
						<h5>Attendees</h5>
						<?php
						$qattendees = "SELECT * FROM attendees WHERE meeting_id = '$meeting_id';";
						$qattendeesrun = mysqli_query($conn,$qattendees);
						?>
						<ul>
							<div class="row">
								<?php
								while ($attendees = mysqli_fetch_assoc($qattendeesrun)) {
								?>
								<div class="col-6">
									<li>
										<div class="row">
											<div class="col">
												<?php echo $attendees['a_name'];?>
											</div>
											<div class="col-4">
												<?php echo "(".$attendees['a_company'].")";?>
											</div>
										</div>
									</li>
								</div>
								<?php
								}
								?>
							</div>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<div id="viewDiv">
			<table>
				<thead>
					<tr>
						<th colspan="3" style="text-align: center; font-size: 18px;">DISCUSSION</th>
					</tr>
				</thead>
				<?php
				$qtopic = "SELECT DISTINCT t.*, n.file_name FROM topic t JOIN mtp_relation rel USING(topic_id) JOIN notes n USING(notes_id) WHERE meeting_id = '$meeting_id';";
				$qtopicr = mysqli_query($conn,$qtopic);
				$i = 1;
				while ($topic_list = mysqli_fetch_assoc($qtopicr)) {
				?>
				<tbody>
					<tr>
						<th width="5%" style="text-align: center;"><?php echo $i++; ?></th>
						<th colspan="2" style="vertical-align: middle;">
							<strong style="font-size: 18px; text-transform: uppercase;"><?php echo $topic_list['topic_name']; ?></strong>
						</th>
					</tr>
					<?php
					if ($result['mt_id'] == 3) {
						$span = 3;
					} else {
						$span = 5;
					}
					?>
					<tr>
						<td rowspan="<?php echo $span; ?>"></td>
						<td>
							<div class="row">
								<div style="padding-left: 1rem; width: 110px;">
									Status
								</div>:
								<div class="col">
									<?php echo $topic_list['topic_status']; ?>
								</div>
							</div>
							<div class="row">
								<div style="padding-left: 1rem; width: 110px;">
									PIC
								</div>:
								<div class="col">
									<?php echo $topic_list['topic_pic']; ?>
								</div>
							</div>
							<div class="row">
								<div style="padding-left: 1rem; width: 110px;">
									Description
								</div>:
								<div class="col">
									<?php echo $topic_list['topic_description']; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php
					if ($result['mt_id'] != 3) {
					?>
					<tr>
						<th colspan="2"><strong>Project</strong></th>
					</tr>
					<tr>
						<td colspan="2">
							<ul>
								<?php
								$topic_id = $topic_list['topic_id'];
								$qproject = "SELECT DISTINCT p.* FROM project p JOIN mtp_relation rel USING(p_id) WHERE meeting_id = '$meeting_id' AND topic_id = '$topic_id';";
								$qprojectr = mysqli_query($conn,$qproject);
								while ($projectnya = mysqli_fetch_assoc($qprojectr)) {
								?>
								<li>
									<button type="button" class="btn btn-link" id="projectnya" style="padding: 0;" data-toggle="modal" data-target="#projectDetail<?php echo $projectnya['p_id']; ?>"><?php echo $projectnya['p_name']; ?></button>
								</li>
								<div class="modal fade" tabindex="-1" id="projectDetail<?php echo $projectnya['p_id']; ?>">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Project Detail</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div style="float: left; width: 130px; margin-left: 15px;">
														<strong>Project Name</strong>
													</div>
													<div style="float: left; width: 20px; text-align: center;">
														:
													</div>
													<div class="col">
														<?php echo $projectnya['p_name']; ?>
													</div>
												</div>
												<div class="row">
													<div style="float: left; width: 130px; margin-left: 15px;">
														<strong>Client</strong>
													</div>
													<div style="float: left; width: 20px; text-align: center;">
														:
													</div>
													<div class="col">
														<?php echo $projectnya['client']; ?>
													</div>
												</div>
												<div class="row">
													<div style="float: left; width: 130px; margin-left: 15px;">
														<strong>Location</strong>
													</div>
													<div style="float: left; width: 20px; text-align: center;">
														:
													</div>
													<div class="col">
														<?php echo $projectnya['location']; ?>
													</div>
												</div>
												<div class="row">
													<div style="float: left; width: 130px; margin-left: 15px;">
														<strong>Schedule</strong>
													</div>
													<div style="float: left; width: 20px; text-align: center;">
														:
													</div>
													<div class="col">
														<?php echo date("l, jS \of F Y", strtotime($projectnya['schedule_start']))." - ".date("l, jS \of F Y", strtotime($projectnya['schedule_finish']));?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
									}
								?>
							</ul>
						</td>
					</tr>
					<?php
					}
					?>
					<tr>
						<th colspan="2"><strong>Minutes</strong></th>
					</tr>
					<tr>
						<td colspan="2">
							<?php
							$file_name = "minutes/".$topic_list['file_name'];
							if (file_exists($file_name)) {
								$file = fopen($file_name, 'r');
								$data = fread($file,filesize($file_name));
								fclose($file);
							} else {
								$data = NULL;
							}
							echo $data;
							?>
						</td>
					</tr>
				</tbody>
				<?php
				}
				?>
			</table>
		</div>
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
				<div class="modal-body">
					<p>Are you sure want to delete this data?</p>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="window.location.href = 'meeting_delete.php?meeting_id=<?php echo $meeting_id; ?>';" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" id="editModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Meeting Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="meeting_edit.php" enctype="multipart/form-data">
				<input class="form-control" name="meeting_id" value="<?php echo $meeting_id; ?>" hidden="">
					<div class="modal-body">
						<div class="form-group">
							<label for="meeting_venue_form"><strong>Meeting Venue</strong></label>
							<input class="form-control" name="meeting_venue" id="meeting_venue_form" value="<?php echo $m_venue; ?>" required="">
						</div>
						<div class="row form-group">
							<div class="col" style="padding-right: 0;">
								<label for="minutes_by_form"><strong>Minutes By</strong></label>
								<input class="form-control" name="minutes_by" id="minutes_by_form" value="<?php echo $minutes_by; ?>" required="">
							</div>
							<div class="col">
								<label for="meeting_date_form"><strong>Meeting Date</strong></label>
								<input class="form-control" name="meeting_date" id="meeting_date_form" type="date" value="<?php echo substr($result['meeting_date'], 0, 10); ?>" required="">
							</div>
						</div>
						<div class="form-group">
							<label><strong>Meeting Time</strong></label>
							<div class="row">
								<div class="col" style="padding-right: 0;">
									<label for="meeting_start_form">Start</label>
									<input class="form-control" name="meeting_start" id="meeting_start_form" type="time" value="<?php echo $result['meeting_start']; ?>" required="">
								</div>
								<div class="col">
									<label for="meeting_finish_form">Finish</label>
									<input class="form-control" name="meeting_finish" id="meeting_finish_form" type="time" value="<?php echo $result['meeting_finish']; ?>" required="">
								</div>
							</div>
						</div>
						<label><strong>Attandees</strong></label>
						<div class="form-group">
							<div data-role="dynamic-fields">
								<?php
								$qattendees = "SELECT * FROM attendees WHERE meeting_id = '$meeting_id';";
								$qattendeesrun = mysqli_query($conn,$qattendees);
								while ($attendees = mysqli_fetch_assoc($qattendeesrun)) {
								?>
								<div class="attandees_form">
									<div class="row">
										<div class="col" style="padding-right: 0;">
											<div class="form-group">
												<input id="a_name" class="form-control" name="a_name[]" placeholder="Name" value="<?php echo $attendees['a_name'];?>">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<input id="a_company" class="form-control" name="a_company[]" placeholder="Department/Division/Company" value="<?php echo $attendees['a_company'];?>">
											</div>
										</div>
										<div style="margin-right: 1rem;">
											<button type="button" class="btn btn-danger" data-role="remove"><span><i class="fa fa-remove"></i></span></button>
											<button type="button" class="btn btn-primary" data-role="add"><span><i class="fa fa-plus"></i></span></button>
										</div>
									</div>
								</div>
								<?php
								}
								?>
								<div class="attandees_form">
									<div class="row">
										<div class="col" style="padding-right: 0;">
											<div class="form-group">
												<input id="a_name" class="form-control" name="a_name[]" placeholder="Name">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<input id="a_company" class="form-control" name="a_company[]" placeholder="Department/Division/Company">
											</div>
										</div>
										<div style="margin-right: 1rem;">
											<button type="button" class="btn btn-danger" data-role="remove"><span><i class="fa fa-remove"></i></span></button>
											<button type="button" class="btn btn-primary" data-role="add"><span><i class="fa fa-plus"></i></span></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="editMeeting" value="editMeeting" class="btn btn-primary">Yes</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
	<script>
	$(function() {
		// Remove button click
		$(document).on(
			'click',
			'[data-role="dynamic-fields"] > .attandees_form [data-role="remove"]',
			function(e) {
				e.preventDefault();
				$(this).closest('.attandees_form').remove();
			}
		);
		// Add button click
		$(document).on(
			'click',
			'[data-role="dynamic-fields"] > .attandees_form [data-role="add"]',
			function(e) {
				e.preventDefault();
				var container = $(this).closest('[data-role="dynamic-fields"]');
				new_field_group = container.children().filter('.attandees_form:first-child').clone();
				new_field_group.find('input').each(function(){
					$(this).val('');
				});
				container.append(new_field_group);
			}
		);
	});

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
	</script>
	<?php
	mysqli_close($conn);
	?>
</body>
</html>