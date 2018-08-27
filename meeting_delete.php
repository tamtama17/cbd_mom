<?php
include('conn.php');
$meeting_id = $_GET['meeting_id'];

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
if (mysqli_query($conn,$qdelmeeting)) {
	header('location:./?flag=2');
} else{
	die(mysqli_error($conn));
}

mysqli_close($conn);
?>