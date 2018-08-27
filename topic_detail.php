<?php
include('conn.php');
$id = intval($_GET['id']);

$qtopic = "SELECT * FROM topic WHERE topic_id = '$id'";
$qrun = mysqli_query($conn,$qtopic);
$topic = mysqli_fetch_assoc($qrun);
?>

<div class="form-group">
	<div class="row">
		<div class="col">
			<label>Topic Description</label>
			<textarea class="form-control" rows="4" name="topic_description_exist[]"><?php echo $topic['topic_description']; ?></textarea>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label>Topic PIC</label>
				<input class="form-control" name="topic_pic_exist[]" value="<?php echo $topic['topic_pic']; ?>">
			</div>
			<div class="form-group">
				<label>Topic Status</label>
				<select class="form-control custom-select" name="topic_status_exist[]">
					<option value="">Choose status</option>
					<?php
					if ($topic['topic_status'] == 'Open') {
						?>
					<option selected="" value="Open">Open</option>
					<option value="Close">Close</option>
						<?php
					} else {
						?>
					<option value="Open">Open</option>
					<option selected="" value="Close">Close</option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
	</div>
</div>
<?php
mysqli_close($conn);
?>