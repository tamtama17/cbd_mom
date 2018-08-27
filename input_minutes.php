<?php
include('conn.php');
if (isset($_POST['newminutes'])) {
	$mt_id = $_POST['mt_id'];
	echo "mt_idnya : ".$mt_id."<br>";
	$minutes_by = $_POST['minutes_by'];
	echo "minutes_bynya : ".$minutes_by."<br>";
	$meeting_venue = $_POST['meeting_venue'];
	echo "venuenya : ".$meeting_venue."<br>";
	echo "<br>";

	$qinsmeeting = "INSERT INTO meeting(minutes_by, meeting_venue, mt_id) VALUES ('$minutes_by', '$meeting_venue', '$mt_id');";
	if (mysqli_query($conn, $qinsmeeting)) {
		$meeting_id = mysqli_insert_id($conn);

		if (!empty($_POST['a_name'])) {
			$a_name = $_POST['a_name'];
			$a_company = $_POST['a_company'];
			$max_att = count($_POST['a_name']);
			echo "attendees:<br>";
			for ($j=0; $j < $max_att; $j++) {
				if ($a_name[$j] != NULL) {
					$a_name_x = $a_name[$j];
					echo $a_name_x."<br>";
					$a_company_x = $a_company[$j];
					echo $a_company_x."<br>";
					$qinstattendees = "INSERT INTO attendees(a_name, a_company, meeting_id) VALUES ('$a_name_x', '$a_company_x', '$meeting_id')";
					if (!mysqli_query($conn, $qinstattendees)) {
						die("Error description: " . mysqli_error($conn));
					}
				}
			}
		}

		if (!empty($_POST['topic_id'])) {
			$topic_id = $_POST['topic_id'];
			$notes = $_POST['notes'];
			$p_id = $_POST['p_id'];
			$jumlah_tid = count($_POST['topic_id']);
			echo "jumlah tid : ".$jumlah_tid."<br>";
			for ($x=0; $x < $jumlah_tid; $x++) {
				$idx = $_POST['indexnya'][$x];
				echo "no. $x<br>";
				if ($topic_id[$x] != NULL) {
					echo "topic_idnya : ".$topic_id[$x]."<br>";
					$topic_id_x = $topic_id[$x];
					$topic_description_x = $_POST['topic_description_exist'][$x];
					echo $topic_description."<br>";
					$topic_pic_x = $_POST['topic_pic_exist'][$x];
					echo $topic_pic."<br>";
					$topic_status_x = $_POST['topic_status_exist'][$x];
					echo $topic_status."<br>";
					$qupdatetopic = "UPDATE topic SET topic_description='$topic_description_x',topic_status='$topic_status_x',topic_pic='$topic_pic_x' WHERE topic_id='$topic_id_x'";
					if (!mysqli_query($conn, $qupdatetopic)) {
						die("Error description: " . mysqli_error($conn));
					}
				} else {
					$new_topic = $_POST['new_topic'][$x];
					echo $new_topic."<br>";
					$topic_description = $_POST['topic_description'][$x];
					echo $topic_description."<br>";
					$topic_status = $_POST['topic_status'][$x];
					echo $topic_status."<br>";
					$topic_pic = $_POST['topic_pic'][$x];
					echo $topic_pic."<br>";
					$qnewtopic = "INSERT INTO topic(topic_name, topic_description, topic_status, topic_pic) VALUES ('$new_topic', '$topic_description', '$topic_status', '$topic_pic');";
					echo $qnewtopic;
					if (mysqli_query($conn, $qnewtopic)) {
						$topic_id_x = mysqli_insert_id($conn);
					} else {
						die("Error description: " . mysqli_error($conn));
					}
				}
				echo "notesnya : ".$notes[$x]."<br>";
				$notes_dir = "minutes/";
				$notes_file_name = $meeting_id."_".$topic_id_x."_".time();
				$notes_full_path = $notes_dir.$notes_file_name;
				$notes_file = fopen($notes_full_path, 'w');
				if (fwrite($notes_file, $notes[$x])) {
					fclose($notes_file);
				}

				$qinsnote = "INSERT INTO notes(file_name) VALUES ('$notes_file_name');";
				if (mysqli_query($conn, $qinsnote)) {
					$notes_id_x = mysqli_insert_id($conn);
					if ($mt_id == 3) {
						echo "project meeting, projectnaya pasti 1.<br>";
						echo "p_idnya : ".$p_id."<br>";
						$qrelation = "INSERT INTO mtp_relation(meeting_id, topic_id, p_id, notes_id) VALUES ('$meeting_id', '$topic_id_x', '$p_id', '$notes_id_x')";
						if (!mysqli_query($conn, $qrelation)) {
							die("Error description: " . mysqli_error($conn));
						}
					} else {
						if (!empty($p_id[$idx])) {
							$n = count($p_id[$idx]);
							echo "n nya : $n<br>";
							for ($i=0; $i < $n; $i++) {
								if ($p_id[$idx][$i] != NULL) {
									$p_id_x = $p_id[$idx][$i];
									echo "p_idnya : ".$p_id_x."<br>";
									$qrelation = "INSERT INTO mtp_relation(meeting_id, topic_id, p_id, notes_id) VALUES ('$meeting_id', '$topic_id_x', '$p_id_x', '$notes_id_x')";
									if (!mysqli_query($conn, $qrelation)) {
										die("Error description: " . mysqli_error($conn));
									}
								}
							}
						}
					}
				} else {
					die("Error description: " . mysqli_error($conn));
				}
				echo "<br>";
			}
		}
		header('location:./?flag=1');
	} else {
		die("Error description: " . mysqli_error($conn));
	}
	
	mysqli_close($conn);
}
?>