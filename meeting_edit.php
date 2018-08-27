<?php
include('conn.php');
if (isset($_POST['editMeeting'])) {
	$meeting_id = $_POST['meeting_id'];
	echo "meeting_id : ".$meeting_id."<br>";
	$meeting_venue = $_POST['meeting_venue'];
	echo "meeting_venue : ".$meeting_venue."<br>";
	$minutes_by = $_POST['minutes_by'];
	echo "minutes_by : ".$minutes_by."<br>";
	$meeting_date = $_POST['meeting_date'];
	echo "meeting_date : ".$meeting_date."<br>";
	$meeting_start = $_POST['meeting_start'];
	echo "meeting_start : ".$meeting_start."<br>";
	$meeting_finish = $_POST['meeting_finish'];
	echo "meeting_finish : ".$meeting_finish."<br>";

	$qupdate = "UPDATE meeting SET minutes_by='$minutes_by',meeting_venue='$meeting_venue',meeting_date='$meeting_date',meeting_start='$meeting_start',meeting_finish='$meeting_finish' WHERE meeting_id = '$meeting_id'";
	if (mysqli_query($conn, $qupdate)) {
		$qdelatt = "DELETE FROM attendees WHERE meeting_id = '$meeting_id'";
		if (mysqli_query($conn, $qdelatt)) {
			if (!empty($_POST['a_name'])) {
				$a_name = $_POST['a_name'];
				$a_company = $_POST['a_company'];
				$max_att = count($_POST['a_name']);
				echo "attendees:<br>";
				for ($j=0; $j < $max_att; $j++) {
					if ($a_name[$j] != NULL) {
						$a_name_x = $a_name[$j];
						$a_company_x = $a_company[$j];
						echo $a_name_x." - ".$a_company_x."<br>";
						$qinstattendees = "INSERT INTO attendees(a_name, a_company, meeting_id) VALUES ('$a_name_x', '$a_company_x', '$meeting_id')";
						if (!mysqli_query($conn, $qinstattendees)) {
							die("Error description: " . mysqli_error($conn));
						}
					}
				}
			}
		} else {
			die("Error description: " . mysqli_error($conn));
		}
		header('location:meeting_detail.php?id='.$meeting_id.'&flag=1');
	} else {
		die("Error description: " . mysqli_error($conn));
	}
	mysqli_close($conn);
}
?>