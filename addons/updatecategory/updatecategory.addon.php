<?php
	if(!defined("__XE__")) exit();
	
	$logged_info = Context::get('logged_info');
	if($logged_info->is_admin != 'Y') return;
	
	$act = Context::get('act');
	$subAct = Context::get('subAct');
	if(!($act == 'procBoardInsertDocument' && $subAct == 'updateCategory')) return;
	
	if($called_position == 'before_module_init') {
		$document_srl = Context::get('document_srl');
		$category_srl = Context::get('category_srl');
		if(!preg_match("/^[0-9]*$/",$document_srl)) return;
		if(!preg_match("/^[0-9]*$/",$category_srl)) return;
		
		$oDocumentModel = getModel('document');

		$oDocument = $oDocumentModel->getDocument($document_srl);
		

		foreach($oDocument->getObjectVars() as $key => $val) {
			Context::set($key, $val, TRUE);
		}
		foreach($oDocument->getExtraVars() as $key => $val) {
			Context::set('extra_vars'.$val->idx, $val->value, TRUE);
		}
		Context::set('category_srl', $category_srl, TRUE);
	}else if($called_position == 'after_module_proc') {
		header('Location: '.Context::get('error_return_url'));
		
		Context::close();
		exit();
	}