<?php
/* Copyright (C) Jiyong Youn> */
/**
 * @class n365
 * @author Jiyong Youn (01@0101010101.com)
 * @version 0.1
 * @brief n365
 */
class n365 extends WidgetHandler
{
	/**
	 * @brief Widget execution
	 * Get extra_vars declared in ./widgets/widget/conf/info.xml as arguments
	 * After generating the result, do not print but return it.
	 */
	function proc($args)
	{
		$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
		$conn->query("SET session character_set_connection=utf8;");
		$conn->query("SET session character_set_results=utf8;");
		$conn->query("SET session character_set_client=utf8;");
		// Set a path of the template skin (values of skin, colorset settings)
		$sql = "SELECT * FROM `xe_documents` WHERE `module_srl`=55958 ORDER BY `list_order` DESC LIMIT " . date('z') . ",1;";

		$q = $conn->query($sql);

		$data = $q->fetch_assoc();

		return '<ul class="list-group"><li class="list-group-item"><h4><strong>' . $data['title'] . '</h4></strong><hr>' . preg_replace('/<a[^>]*>[^<]*<\\/a>/', '', $data['content']) . '</li></ul>';
	}
}
/* End of file n365_class.php */
/* Location: ./widgets/n365/n365_class.php */
