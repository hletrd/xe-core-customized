<?php
/* Copyright (C) Jiyong Youn */
/**
 * @file	member_condition.admin.view.php
 * @author	Jiyong Youn
 * @brief	admin view class of the member_condition module
 */
class member_conditionAdminView extends member_condition
{
	/**
	 * Initialization
	 * @return void
	 */
	public function init()
	{
	}

	public function dispMember_conditionAdminConfig()
	{
		$oMember_conditionModel = getModel('member_condition');
		$member_condition_config = $oMember_conditionModel->getMember_conditionConfig();

		Context::set('answer', $member_condition_config->answer);

		// Specify a template
		$this->setTemplatePath($this->module_path.'tpl');
		$this->setTemplateFile('member_condition_config');
	}
}
/* End of file member_condition.admin.view.php */
/* Location: ./modules/member_condition/member_condition.admin.view.php */