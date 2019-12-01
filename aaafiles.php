<?php
date_default_timezone_set('Asia/Seoul');

ini_set("display_errors", 1);

define('__XE__', true);
require_once("config/config.inc.php");

$oContext = &Context::getInstance();
$oContext->init();
$logged_info = Context::get('logged_info');
$info = $logged_info->group_list;

/*$perm = false;
foreach($info as $each) {
	if ($each === '준회원') $perm = true;
}*/
if (/*$perm == true*/ $logged_info !== NULL) {
	require_once('dbconfig.php');
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
	$conn->query("SET session character_set_connection=utf8;");
	$conn->query("SET session character_set_results=utf8;");
	$conn->query("SET session character_set_client=utf8;");

	if (Context::get('download') !== NULL) {
		$result = $conn->query("SELECT * FROM `aaa_file` WHERE `no`='" . intval(Context::get('download')) . "';");
		$row = $result->fetch_assoc();
		$conn->query("UPDATE `aaa_file` SET `download` = `download`+1 WHERE `no` = " . intval(Context::get('download')));
		$filelink = '.' . $row['s_filename'];
		header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($row['filename']).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filelink));
    readfile($filelink);

    exit();
	} else {

		$result = $conn->query("SELECT * FROM `aaa_file` ORDER BY period DESC;");
		echo '<table class="table table-striped table-condensed">';
		echo '<thead><tr><th>회기</th><th>항목</th><th>파일</th><th>메모</th><th>다운로드</th></tr></thead>';
		echo '<tbody>';

		$category = array("","선본자료집","선본대화록","총회자료집","총회대화록","LT자료집","LT대화록","사진전관련","관측회관련","디딤돌관련","기타문서");

		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
			echo '<td>' . $row['period'] . '</td><td>' . $category[$row['category']] . '</td><td><a href="/aaafilesdownload?download=' . $row['no'] . '">'. $row['filename'] . '</td><td>' . $row['des'] . '</td><td>' . $row['download'] . '</td>';
			echo '</tr>';
		}
		
		echo '</tbody></table>';
	}
}
?>
