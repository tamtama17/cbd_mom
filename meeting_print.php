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
	$meeting_id = $_GET['meeting_id'];
	$qselect = "SELECT * FROM meeting JOIN m_type USING(mt_id) WHERE meeting_id='$meeting_id';";
	$qrun = mysqli_query($conn,$qselect);
	$result = mysqli_fetch_assoc($qrun);
	?>
	<div style="padding: 2rem;">
		<h2>Minutes Of Meeting</h2>
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
						$m_time = date("h:i A", strtotime($result['meeting_date']));
						echo "TIME : ".$m_time;
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
					<td style="text-transform: uppercase;">
						PROJECT NAME : <?php echo $projectnya['p_name']; ?>
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
		<div>
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
						<th colspan="2"><strong style="font-size: 18px; text-transform: uppercase;"><?php echo $topic_list['topic_name']; ?></strong></th>
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
								<div class="col-1">
									Status
								</div>:
								<div class="col">
									<?php echo $topic_list['topic_status']; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-1">
									PIC
								</div>:
								<div class="col">
									<?php echo $topic_list['topic_pic']; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-1">
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
									<?php echo $projectnya['p_name']; ?>
								</li>
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