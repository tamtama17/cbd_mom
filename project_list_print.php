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
	?>
	<div style="padding: 2rem;">
		<h2>Project List</h2>
		<hr class="my-4">
		<table>
			<thead>
				<tr>
					<th width="100px">Job Code</th>
					<th>Project Name</th>
					<th width="25%">Client</th>
					<th width="12%">Start Date</th>
					<th width="12%">Finish Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$qselect = "SELECT * FROM project;";
				$qrun = mysqli_query($conn,$qselect);
				while ($result = mysqli_fetch_assoc($qrun)) {
					?>
					<tr>
						<td style="text-align: center;"><?php echo $result['job_code']; ?></td>
						<td><?php echo $result['p_name']; ?></td>
						<td><?php echo $result['client']; ?></td>
						<td>
							<?php
							if ($result['schedule_start'] == '' || $result['schedule_start'] == NULL || $result['schedule_start'] == '0000-00-00') {
								echo "-";
							}
							else {
								echo date("F jS, Y", strtotime($result['schedule_start']));
							}
							?>
						</td>
						<td>
							<?php
							if ($result['schedule_finish'] == '' || $result['schedule_finish'] == NULL || $result['schedule_finish'] == '0000-00-00') {
								echo "-";
							}
							else {
								echo date("F jS, Y", strtotime($result['schedule_finish']));
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
		th {
			text-align: center;
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