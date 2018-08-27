<?php
include('conn.php');
if (isset($_POST['del_project'])) {
	$p_id = $_POST['p_id'];
	echo "p_idnya : ".$p_id."<br>";

	$del_project = "DELETE FROM project WHERE p_id = '$p_id'";
	if (mysqli_query($conn,$del_project)) {
		if (isset($_POST['del_meeting'])) {
			$qmeeting = "SELECT DISTINCT meeting_id, mt_id FROM mtp_relation JOIN meeting USING(meeting_id) WHERE p_id = '$p_id';";
			$qmeetingrun = mysqli_query($conn,$qmeeting);
			while ($meetingnya = mysqli_fetch_assoc($qmeetingrun)) {
				$meeting_id = $meetingnya['meeting_id'];
				if ($meetingnya['mt_id'] == '3') {
					$notes_dir = "minutes/";
					$qceknotes = "SELECT DISTINCT n.* FROM mtp_relation rel JOIN notes n USING(notes_id) WHERE meeting_id = '$meeting_id';";
					$qceknotes_run = mysqli_query($conn,$qceknotes);
					while ($ceknotes = mysqli_fetch_assoc($qceknotes_run)) {
						$notes_id_x = $ceknotes['notes_id'];
						$file_name_x = $notes_dir.$ceknotes['file_name'];
						$qdelnotes = "DELETE FROM notes WHERE notes_id = '$notes_id_x'";
						if (mysqli_query($conn,$qdelnotes)) {
							unlink("$file_name_x");
						} else{
							die(mysqli_error($conn));
						}
					}

					$qdelmeeting = "DELETE FROM meeting WHERE meeting_id = '$meeting_id';";
					if (!mysqli_query($conn,$qdelmeeting)) {
						die(mysqli_error($conn));
					}
				} else {
					$qdel_relation = "DELETE FROM mtp_relation WHERE p_id = '$p_id'";
					if (!mysqli_query($conn,$qdel_relation)) {
						die(mysqli_error($conn));
					}
				}
			}
		}
		header('location:./?flag=2');
	} else{
		die(mysqli_error($conn));
	}
}

mysqli_close($conn);
?>