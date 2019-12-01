<?php

ini_set('max_execution_time', 300);

require_once('dbconfig.php');
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn2 = new mysqli($db_host, $db_user, $db_pass, $db_name);

$result = $conn->query("SELECT * FROM `xe_member`;");
while ($row = $result->fetch_assoc()) {
	$group2 = false;
	$group3 = false;
	$time = new DateTime($row['regdate']);
	$time_ref = new DateTime('-1 year');
	
	if ($time_ref > $time) {
		$group3 = true;
	}

	$result_member = $conn2->query("SELECT * FROM `xe_member_group_member` WHERE `member_srl`='" . $row['member_srl'] . "';");
	while ($member = $result_member->fetch_assoc()) {
		if ($member['group_srl'] == 2) {
			$group2 = false;
		}
		if ($member['group_srl'] == 3) {
			$group3 = false;
		}
	}
	if ($group2 === true) {
		$conn2->query("INSERT INTO `xe_member_group_member` (`site_srl`, `group_srl`, `member_srl`, `regdate`) VALUES ('0', '2', '" . $row['member_srl'] . "', '" . strftime('%Y%m%d%H%M%S', time()) . "');");
	}
	if ($group3 === true) {
		$conn2->query("INSERT INTO `xe_member_group_member` (`site_srl`, `group_srl`, `member_srl`, `regdate`) VALUES ('0', '3', '" . $row['member_srl'] . "', '" . strftime('%Y%m%d%H%M%S', time()) . "');");
	}
}