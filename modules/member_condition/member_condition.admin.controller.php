<?php
/* Copyright (C) Jiyong Youn */
/**
 * @file	member_condition.admin.controller.php
 * @author	Jiyong Youn
 * @brief	admin controller class of the member_condition module
 */
class member_conditionAdminController extends member_condition
{
	/**
	 * Initialization
	 * @return void
	 */
	public function init()
	{
	}

	/**
	 * @brief 회원 가입 질문
	 * @author Jiyong Youn
	 * @param string $question, $answer
	 */
	public function procMember_conditionAdminConfig()
	{
		$oModuleController = getController('module');
		$config = new stdClass();

		$config->answer = trim(Context::get('answer'));
		
		$oModuleController->insertModuleConfig('member_condition', $config);
		$this->setRedirectUrl(Context::get('error_return_url'));
	}
}
/* End of file member_condition.admin.controller.php */
/* Location: ./modules/member_condition/member_condition.admin.controller.php */