<!DOCTYPE html>
<html>
<head>
	<?php
	include('head.php');
	?>
	<style type="text/css">
	[data-role="dynamic-fields"] > .dinamic_form [data-role="add"] {
		display: none;
	}

	[data-role="dynamic-fields"] > .dinamic_form:last-child [data-role="add"] {
		display: inline-block;
	}

	[data-role="dynamic-fields"] > .dinamic_form:last-child [data-role="remove"] {
		display: none;
	}

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

	if (isset($_GET['m_typenya'])) {
		$mt_id = $_GET['mt_id'];
		$p_id = $_GET['p_id'];
		if ($mt_id != NULL) {
		} else {
			$mt_name = $_GET['p_name'];
			$qnewmt = "INSERT INTO m_type(mt_name) VALUES ('$mt_name');";
			if (mysqli_query($conn, $qnewmt)) {
				$mt_id = mysqli_insert_id($conn);
			} else {
				die("Failed to insert new Meeting Type.<br>Error description: " . mysqli_error($conn));
			}
		}
	} else{
		die('<h4 style="padding: 2rem;">Error description : Please choose meeting type first!</h4>');
	}
	$qmt = "SELECT * FROM m_type WHERE mt_id = '$mt_id';";
	$qmtrun = mysqli_query($conn,$qmt);
	$mtype = mysqli_fetch_assoc($qmtrun);
	?>
	<div style="padding: 2rem;">
		<h2><?php echo $mtype['mt_name']; ?></h2>
		<?php if ($mt_id == 3) {
			$qproject = "SELECT * FROM project WHERE p_id = '$p_id';";
			$qprojectr = mysqli_query($conn,$qproject);
			$projectnya = mysqli_fetch_assoc($qprojectr);
		?>
		<h4><?php echo $projectnya['p_name']; ?></h4>
		<?php
		} ?>
		<small>
			<?php
			echo date("l, jS \of F Y");
			?>
		</small>
		<form method="post" action="input_minutes.php" enctype="multipart/form-data">
			<input class="form-control" name="mt_id" value="<?php echo $mt_id; ?>" hidden="">
			<?php if ($mt_id == 3) {
			?>
			<input class="form-control" name="p_id" value="<?php echo $p_id; ?>" hidden="">
			<?php
			} ?>
			<div class="row" style="margin-top: 10px;">
				<div class="col-4" style="padding-right: 0;">
					<input class="form-control" name="minutes_by" id="minutes_by_form" required="" placeholder="Minutes by">
				</div>
				<div class="col">
					<input class="form-control" name="meeting_venue" id="meeting_venue_form" required="" placeholder="Meeting Venue">
				</div>
				<div style="margin-right: 1rem;">
					<button id="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#attandees_modal"><span><i class="fa fa-plus"></i></span> Attandees</button>
				</div>
				<div class="modal fade" tabindex="-1" id="attandees_modal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Attendees</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<div data-role="dynamic-fields">
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
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="my-4">
			<div data-role="dynamic-fields">
				<div class="dinamic_form">
				<input class="indexnya" id="idxproject" name="indexnya[]" value="0" hidden="">
					<div id="existingData">
						<div class="form-group">
							<label><h5>Topic</h5></label>
							<div class="row">
								<div class="col">
									<select id="topicSelect" onchange="gantiTopic(this.value, this.id)" class="form-control custom-select" name="topic_id[]" required="">
										<option value="" selected="">Choose topic</option>
										<?php
										$qtopic = "SELECT * FROM topic;";
										$qtopicr = mysqli_query($conn,$qtopic);
										while ($topic = mysqli_fetch_assoc($qtopicr)) {
										?>
											<option value='<?php echo $topic['topic_id']; ?>'><?php echo $topic['topic_name']; ?></option>
										<?php
											}
										?>
									</select>
									<small id="topicHelp" class="form-text text-muted">If topic doesn't exist, click '<span><i class="fa fa-plus"></i></span> New' button to create new</small>
								</div>
								<div style="margin-right: 1rem;">
									<button id="" type="button" onclick="newTopic(this.id)" class="btn btn-primary"><span><i class="fa fa-plus"></i></span> New</button>
								</div>
							</div>
						</div>
						<div id="detailnyatopic"></div>
					</div>
					<div id="newData" style="display: none;">
						<div class="form-group">
							<label><h5>Topic</h5></label>
							<div class="row">
								<div class="col">
									<input id="topicInput" class="form-control" name="new_topic[]">
									<small id="comHelp" class="form-text text-muted">Click '<span><i class="fa fa-times"></i></span> Cancel' button to select from existing topic</small>
								</div>
								<div style="margin-right: 1rem;">
									<button id="" type="button" onclick="newTopicCancel(this.id)" class="btn btn-danger"><span><i class="fa fa-times"></i></span> Cancel</button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col">
									<label>Topic Description</label>
									<textarea id="desc_form" class="form-control" rows="4" name="topic_description[]"></textarea>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label>Topic PIC</label>
										<input id="topic_pic_form" class="form-control" name="topic_pic[]">
									</div>
									<div class="form-group">
										<label>Topic Status</label>
										<select id="status_form" class="form-control custom-select" name="topic_status[]">
											<option value="" selected="">Choose status</option>
											<option value="Open">Open</option>
											<option value="Close">Close</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ($mt_id != 3) {
					?>
					<div class="form-group">
						<label><h5>Select Project</h5></label>
						<select style="width: 100%;" class="pilih_project form-control" name="p_id[0][]" required="" multiple="">
							<?php
							$qproject = "SELECT * FROM project;";
							$qprojectr = mysqli_query($conn,$qproject);
							while ($project_list = mysqli_fetch_assoc($qprojectr)) {
							?>
								<option value='<?php echo $project_list['p_id']; ?>'><?php echo $project_list['job_code']." - ".$project_list['p_name']; ?></option>
							<?php
								}
							?>
						</select>
					</div>
					<?php
					}
					?>
					<div class="form-group">
						<label for="minutes"><h5>Minutes of Meeting</h5></label>
						<textarea class="notul" id="notulnya" name="notes[]"></textarea>
					</div>
					<button type="button" style="float: right; border-radius: 100%;" class="btn btn-danger" data-role="remove"><span><i class="fa fa-remove"></i></span></button>
					<button type="button" style="float: right; border-radius: 100%;" class="btn btn-primary" data-role="add"><span><i class="fa fa-plus"></i></span></button>
					<br>
					<hr class="my-4">
				</div>
			</div>
			<button type="submit" name="newminutes" class="btn btn-primary">Submit</button>
		</form>
	</div>

	<script>
	function newTopic(idnya) {
		document.getElementById("newData"+idnya).style.display = "block";
		document.getElementById("existingData"+idnya).style.display = "none";
		document.getElementById('topicSelect'+idnya).selectedIndex = 0;
		document.getElementById("detailnyatopic"+idnya).innerHTML="";
		document.getElementById("topicSelect"+idnya).required = false;
		document.getElementById("topicInput"+idnya).required = true;
	}
	function newTopicCancel(idnya) {
		document.getElementById("newData"+idnya).style.display = "none";
		document.getElementById("existingData"+idnya).style.display = "block";
		document.getElementById('topicInput'+idnya).value = '';
		document.getElementById('desc_form'+idnya).value = '';
		document.getElementById('status_form'+idnya).value = '';
		document.getElementById('topic_pic_form'+idnya).value = '';
		document.getElementById("topicInput"+idnya).required = false;
		document.getElementById("topicSelect"+idnya).required = true;
	}

	var idx = 0;
	var id_froala = 'textarea#notulnya';
	$(function() { $(id_froala).froalaEditor() });

	$(function() {
		// Remove button click
		$(document).on(
			'click',
			'[data-role="dynamic-fields"] > .dinamic_form [data-role="remove"]',
			function(e) {
				idx--;
				e.preventDefault();
				$(this).closest('.dinamic_form').remove();
			}
		);
		// Add button click
		$(document).on(
			'click',
			'[data-role="dynamic-fields"] > .dinamic_form [data-role="add"]',
			function(e) {
				idx++;
				e.preventDefault();
				var container = $(this).closest('[data-role="dynamic-fields"]');
				new_field_group = container.children().filter('.dinamic_form:first-child').clone();
				new_field_group.find('input').each(function(){
					var id_name = $(this).attr('id');
					$(this).attr('id', id_name+idx);
					if ($(this).attr('class') == 'indexnya') {
						$(this).attr('value', idx);
					} else{
						$(this).val('');
					}
				});
				new_field_group.find('select').each(function(){
					$(this).val('');
					var id_name = $(this).attr('id');
					$(this).attr('id', id_name+idx);
					<?php if ($mt_id != 3) {
					?>
					if ($(this).attr('class') == 'pilih_project form-control') {
						$(this).attr('name', 'p_id['+idx+'][]');
					}
					<?php
					} ?>
				});
				new_field_group.find('textarea').each(function(){
					$(this).val('');
					var id_name = $(this).attr('id');
					$(this).attr('id', id_name+idx);
					if ($(this).attr('class') == 'notul') {
						id_froala_baru = 'textarea#'+id_name+idx;
						$(function() { $(id_froala_baru).froalaEditor() });
					}
				});
				new_field_group.find('div').each(function(){
					if ($(this).attr('id')) {
						var id_name = $(this).attr('id');
						$(this).attr('id', id_name+idx);
					}
					if ($(this).attr('class') == 'fr-box fr-basic fr-top') {
						$(this).remove();
					}
				});
				new_field_group.find('button').each(function(){
					var id_name = $(this).attr('id');
					$(this).attr('id', id_name+idx);
				});
				container.append(new_field_group);
			}
		);
	});

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

	function gantiTopic(str,idtopic) {
		var idnya = idtopic.substring(11);
		if (str=="") {
			document.getElementById("detailnyatopic"+idnya).innerHTML="";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("detailnyatopic"+idnya).innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","topic_detail.php?id="+str,true);
		xmlhttp.send();
	}
	</script>
	<?php
	mysqli_close($conn);
	?>
</body>
</html>