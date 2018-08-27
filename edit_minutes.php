<?php
include('conn.php');
if (isset($_POST['editminute'])) {
	$meeting_id = $_POST['meeting_id'];
	$qmeeting = "SELECT * FROM meeting WHERE meeting_id = '$meeting_id'";
	$qrun = mysqli_query($conn,$qmeeting);
	$datalama = mysqli_fetch_assoc($qrun);
	$topic_id_lama = $datalama['topic_id'];
	$notes_lama = $datalama['notes'];
	echo "$meeting_id<br>";

	$topic_id = $_POST['topic_id'];
	if ($topic_id != NULL) {
		echo "$topic_id<br>";
	} else {
		$new_topic = $_POST['new_topic'];
		echo "$new_topic<br>";
		$topic_description = $_POST['topic_description'];
		echo "$topic_description<br>";
		$topic_status = $_POST['topic_status'];
		echo "$topic_status<br>";
		 $qnewtopic = "INSERT INTO topic(topic_name, topic_description, topic_status) VALUES ('$new_topic', '$topic_description', '$topic_status');";
		if (mysqli_query($conn, $qnewtopic)) {
			$topic_id = mysqli_insert_id($conn);
		} else {
			die("Error description: " . mysqli_error($conn));
		}
	}

	$notes = $_POST['notes'];
	echo "$notes<br>";
	$notes_dir = "minutes/";
	$notes_file_name = $notes_lama;
	$notes_full_path = $notes_dir.$notes_file_name;
 	$notes_file = fopen($notes_full_path, 'w');
	if (fwrite($notes_file, $notes)) {
		fclose($notes_file);
		$qupdate = "UPDATE meeting SET topic_id='$topic_id', notes='$notes_file_name' WHERE meeting_id = '$meeting_id'";
		if (mysqli_query($conn, $qupdate)) {
			$qcektopic = "SELECT COUNT(topic_id) AS jumlah FROM meeting WHERE topic_id = '$topic_id_lama';";
			$qcekrun = mysqli_query($conn,$qcektopic);
			$cektopic = mysqli_fetch_assoc($qcekrun);
			if ($cektopic['jumlah'] < 1) {
				$qdeltopic = "DELETE FROM topic WHERE topic_id = '$topic_id_lama';";
				if ($qdelrun = mysqli_query($conn,$qdeltopic)) {
					header('location:meeting_detail.php?id='.$meeting_id.'&flag=1');
				} else {
					die("Error description: " . mysqli_error($conn));
				}
			}
		} else {
			die("Error description: " . mysqli_error($conn));
		}
	}
	
	mysqli_close($conn);
}
?>