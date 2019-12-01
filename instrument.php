<?php
date_default_timezone_set('Asia/Seoul');

ini_set("display_errors", 1);

define('__XE__', true);
require_once("config/config.inc.php");

/*$oContext = &Context::getInstance();
$oContext->init();
$logged_info = Context::get('logged_info');
$info = $logged_info->group_list;*/

/*$perm = false;
foreach($info as $each) {
	if ($each === '준회원') $perm = true;
}*/
if (/*$perm == true*/ true) {

	// 원하는 시간대
	$times = array(
	   '11:00 ~ 12:30',
	   '12:30 ~ 14:00',
	   '14:00 ~ 15:30',
	   '15:30 ~ 17:00',
	   '17:00 ~ 18:30',
	   //'18:30 ~ 20:00',
	);
	 
	$days = array(
	   '2019-11-11',
	   '2019-11-12',
	   '2019-11-13',
	   '2019-11-14',
	   '2019-11-15',
	   '2019-11-18',
	   '2019-11-19',
	   '2019-11-20',
	   '2019-11-21',
	   '2019-11-22',

	);

	// 여기부터는 편집하지 마세요


	$taavailable = false;

	$stuavailable = true;

	if (isset($_GET['type']) && $_GET['type'] === '2746'/* && $logged_info !== NULL*/) {
		$taavailable = true;
		$stuavailable = false;
	}



	?>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<style>
		.spacer {
			height: 15px;
		}
		.ta {
			background-color: #ffc9ad !important;
		}
		.time {
			background-color: #c3e6cb !important;
		}
		.nowrap {
			white-space: nowrap;
		}
		.table-warning {
			background-color: #fff3cd;
		}
		.table-info {
			background-color: #d1ecf1;
		}
		.thead {
			background-color: #cce5ff;
		}
		</style>
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
	<?php
	if ($taavailable === false) {
	?>
		<div class="alert alert-danger" role="alert">
			<h4>하루에 두개 장비의 실습은 불가능합니다!</h4>
		</div>
	<?php
	}
	?>
	<?php /*	<div class="alert alert-warning alert-dismissible fade show" role="alert">
			.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>*/
	?>
	<?php
	if ($taavailable === false) {
	?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			취소는 디딤돌짱이나 디딤돌 강사님/조장님/장비실습 담당 강사님께 문의해주세요. 실습 직전에 취소하실 경우 꼭 장비실습 담당 강사님과 먼저 협의 부탁드립니다.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php
	} 
	?>
	<?php

	ini_set("display_errors", "1");
	//error_reporting(-1);

	//date_default_timezone_set("Asia/Seoul");
	require_once('dbconfig.php');
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
	$conn->query("SET session character_set_connection=utf8;");
	$conn->query("SET session character_set_results=utf8;");
	$conn->query("SET session character_set_client=utf8;");

	//$conn->query("CREATE TABLE list_tnbi(id INT NOT NULL auto_increment, name TEXT NOT NULL, atime DATETIME NOT NULL, type TEXT NOT NULL, udate TEXT NOT NULL, utime TEXT NOT NULL, phone TEXT NOT NULL, PRIMARY KEY (id));");

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['delete'])) {
		$name = $conn->real_escape_string($_POST['name']);
		$type = $conn->real_escape_string($_POST['type']);
		$day = $conn->real_escape_string($_POST['day']);
		$time = $conn->real_escape_string($_POST['time']);
		if (isset($_POST['phone'])) {
			$phone = $conn->real_escape_string($_POST['phone']);
		} else {
			$phone = '';
		}

		if (!$conn->query('INSERT INTO list_tnbi SET name="' . $name . '", atime=NOW(), type="' . $type . '", udate="' . $day . '", utime="' . $time . '", phone="' . $phone . '"')) {
			printf("err: %s\n", $conn->error);
	    exit();
		}
		exit();
	} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['delete'])) {
		$conn->query('DELETE FROM `list_tnbi` WHERE `list_tnbi`.`id` = "' . $conn->real_escape_string($_POST['id']) . '"');
	}



	$dayofweek = array(
		'일',
		'월',
		'화',
		'수',
		'목',
		'금',
		'토'
	);

	echo '	<table class="table table-sm table-responsive nowrap">
			<thead>
				<tr>
					<th rowspan="2">시간</th>
					<th rowspan="2" class="nowrap">장비</th>
	';
	foreach($days as $day) {
	echo '				<th colspan="3">' . $day . ' (' . $dayofweek[date('w', strtotime($day))] . ')</th>
	';
	}
	echo '			</tr>
				<tr>
	';
	foreach($days as $day) {
	echo '				<th>담당자</th>
					<th>수강생1</th>
					<th>수강생2</th>
	';
	}
	echo '			</tr>
			</thead>
			<tbody>
	';


	$all = array();
	foreach($days as $day) {
		$all[$day] = array();
		foreach($times as $time) {
			$all[$day][$time] = array();
			$all[$day][$time]['f'] = array();
			$all[$day][$time]['f']['ta'] = '';
			$all[$day][$time]['f']['ta_id'] = '';
			$all[$day][$time]['f']['stu'] = array();
			$all[$day][$time]['f']['stu'][0] = '';
			$all[$day][$time]['f']['stu'][1] = '';
			$all[$day][$time]['g'] = array();
			$all[$day][$time]['g']['ta'] = '';
			$all[$day][$time]['g']['ta_id'] = '';
			$all[$day][$time]['g']['stu'] = array();
			$all[$day][$time]['g']['stu'][0] = '';
			$all[$day][$time]['g']['stu'][1] = '';
		}
	}


	$q = $conn->query('SELECT * FROM list_tnbi;');

	while($data = $q->fetch_array()) {
		$name = htmlspecialchars($data[1]);
		$type = $data[3];
		$udate = $data[4];
		$utime = $data[5];

		if (($type === 'g' || $type === 'f') && $taavailable === true && $data[6] !== '') {
			$name .= '<br />(';
			$name .= htmlspecialchars($data[6]);
			$name .= ')';
			$name .= '<br /><button class="btn btn-danger delete" data-index="' . $data[0] . '">삭제</button>';
		}

		if ($type === 'g_ta') {
			$all[$udate][$utime]['g']['ta'] = $name;
			$all[$udate][$utime]['g']['ta_id'] = $data[0];
		} else if ($type === 'f_ta') {
			$all[$udate][$utime]['f']['ta'] = $name;
			$all[$udate][$utime]['f']['ta_id'] = $data[0];
		} else if ($type === 'g') {
			if ($all[$udate][$utime]['g']['stu'][0] === '')
				$all[$udate][$utime]['g']['stu'][0] = $name;
			else
				$all[$udate][$utime]['g']['stu'][1] = $name;
		} else if ($type === 'f') {
			if ($all[$udate][$utime]['f']['stu'][0] === '')
				$all[$udate][$utime]['f']['stu'][0] = $name;
			else
				$all[$udate][$utime]['f']['stu'][1] = $name;
		}
	}

	foreach($times as $time) {
		$time_print = str_replace(' ', '&nbsp;', $time);
		echo '			<tr class="table-warning">
					<td class="time" rowspan="2"><strong>' . $time_print . '</strong></td>';
		echo '				<td>곽</td>';
		foreach($days as $day) {

	echo '				<td class="ta">';

		if ($all[$day][$time]['g']['ta'] === '' && $taavailable)
			echo '<button class="btn btn-success apply" data-time="' . $time . '" data-day="' . $day . '" data-type="g_ta" data-toggle="modal" data-target="#popup">신청</button>';
		else {
			if ($taavailable && $all[$day][$time]['g']['stu'][0] === '' && $all[$day][$time]['g']['stu'][1] === '') {
				echo '<strong>' . $all[$day][$time]['g']['ta'] . '<br />';
				echo '<button class="btn btn-danger delete" data-index="' . $all[$day][$time]['g']['ta_id'] . '">삭제</button>';
				echo '</strong>';
			} else {
				echo '<strong>' . $all[$day][$time]['g']['ta'] . '</strong>';
			}
		}
	echo '</td>
					<td>';
		if ($all[$day][$time]['g']['ta'] !== '' && $all[$day][$time]['g']['stu'][0] === '' && $stuavailable)
			echo '<button class="btn btn-primary apply" data-time="' . $time . '" data-day="' . $day . '" data-type="g" data-toggle="modal" data-target="#popup">신청</button>';
		else
			echo $all[$day][$time]['g']['stu'][0];
	echo '</td>
					<td>';
		if ($all[$day][$time]['g']['ta'] !== '' && $all[$day][$time]['g']['stu'][1] === '' && $stuavailable)
			echo '<button class="btn btn-primary apply" data-time="' . $time . '" data-day="' . $day . '" data-type="g" data-toggle="modal" data-target="#popup">신청</button>';
		else
			echo $all[$day][$time]['g']['stu'][1];
	echo '</td>
	';
		}
		echo '			</tr>
				<tr class="table-info">';
		echo '				<td>FS-102</td>';
		foreach($days as $day) {
	echo '				<td class="ta">';

		if ($all[$day][$time]['f']['ta'] === '' && $taavailable)
			echo '<button class="btn btn-success apply" data-time="' . $time . '" data-day="' . $day . '" data-type="f_ta" data-toggle="modal" data-target="#popup">신청</button>';
		else  {
			if ($taavailable && $all[$day][$time]['f']['stu'][0] === '' && $all[$day][$time]['f']['stu'][1] === '') {
				echo '<strong>' . $all[$day][$time]['f']['ta'] . '<br />';
				echo '<button class="btn btn-danger delete" data-index="' . $all[$day][$time]['f']['ta_id'] . '">삭제</button>';
				echo '</strong>';
			} else {
				echo '<strong>' . $all[$day][$time]['f']['ta'] . '</strong>';
			}
		}
	echo '</td>
					<td>';
		if ($all[$day][$time]['f']['ta'] !== '' && $all[$day][$time]['f']['stu'][0] === '' && $stuavailable)
			echo '<button class="btn btn-primary apply" data-time="' . $time . '" data-day="' . $day . '" data-type="f" data-toggle="modal" data-target="#popup">신청</button>';
		else
			echo $all[$day][$time]['f']['stu'][0];
	echo '</td>
					<td>';
		if ($all[$day][$time]['f']['ta'] !== '' && $all[$day][$time]['f']['stu'][1] === '' && $stuavailable)
			echo '<button class="btn btn-primary apply" data-time="' . $time . '" data-day="' . $day . '" data-type="f" data-toggle="modal" data-target="#popup">신청</button>';
		else
			echo $all[$day][$time]['f']['stu'][1];
	echo '</td>
	';
		}
		echo '			</tr>';
	}
	?>
			</tbody>
		</table>

	<div class="modal fade" id="popup" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="popuplabel"></h5>
					<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body" id="body">
						
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
					<button type="button" class="btn btn-primary" id="submit">신청</button>
				</div>
			</div>
		</div>
	</div>
	<footer class="text-center text-muted"><small>2018년 3월 제작, 2019년 3월 1차 수정, 2019년 10월 2차 수정 by 76대 디딤돌짱 윤지용</small></footer>
	<script>
	var isphone = false;
	$('.apply').on('click', function(e) {
		var label = '';
		var phone = '<input id="phone" type="hidden">';
		
		<?php
	if ($taavailable === true) {
	echo "if ($(e.target).data('type') === 'g_ta') {
			label = '곽 장비실습 담당자 신청';
		} else if ($(e.target).data('type') === 'f_ta') {
			label = 'FS-102 장비실습 담당자 신청';
		} else ";
	}
		?> if ($(e.target).data('type') === 'g') {
			label = '곽 장비실습 신청';
			isphone = true;
			phone = '<div class="spacer"></div><div class="row"><div class="col-sm-4"><label>연락처</label></div><div class="col-sm-8"><input id="phone" type="tel" class="form-control" placeholder="연락처"></div></div>';
		} else if ($(e.target).data('type') === 'f') {
			label = 'FS-102 장비실습 신청';
			isphone = true;
			phone = '<div class="spacer"></div><div class="row"><div class="col-sm-4"><label>연락처</label></div><div class="col-sm-8"><input id="phone" type="tel" class="form-control" placeholder="연락처" value=""></div></div>';
		}
		$('#popuplabel').text(label);

		var value = '<div class="row"><div class="col-sm-4"><label>이름</label></div><div class="col-sm-8"><input id="name" type="text" class="form-control" placeholder="이름" value=""></div></div>' + phone + '<input id="type" type="hidden" value="' + $(e.target).data('type') + '"><input id="day" type="hidden" value="' + $(e.target).data('day') + '"><input id="time" type="hidden" value="' + $(e.target).data('time') + '"><div class="spacer"></div><div class="row"><div class="col-sm-12"></div><div class="col-sm-8">	<?php
	if ($taavailable === false) {
		echo '<label>부득이하게 취소하게 될 경우 돌짱이나 강사/조장님에게 문의하시기 바랍니다. 직전에 취소하실 경우 먼저 장비실습 담당 강사님과 협의 후 취소해주세요.</label>';
	}
	?></div></div>';

		$('#body').html(value);
	});

	$('#submit').on('click', function(e) {
		var name = $('#name').val();
		var day = $('#day').val();
		var time = $('#time').val();
		var type = $('#type').val();
		var phone = $('#phone').val();

		if (name !== '' && (isphone === false || phone !== '')) {
			$.post('./?mid=instrument', {
				name: name,
				day: day,
				type: type,
				time: time,
				phone: phone
			}).done(function(){
				window.location.reload();
			});
		} else {
			window.location.reload();
		}

	});
	<?php
	if ($taavailable === true) {
	echo "
	$('.delete').on('click', function(e) {
		if (confirm('ㄹㅇ??')) {
			$.post('./?mid=instrument&delete=delete', {
				id: $(e.target).data('index') 
			}).done(function(){
				window.location.reload();
			});
		}
	});";
	}
	?>
	</script>
<?php
}
?>