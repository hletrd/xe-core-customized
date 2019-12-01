<?php
/* Copyright (C) Jiyong Youn */
/**
 * @class  member_condition
 * @author Jiyong Youn
 * high class of the member_condition module
 */
class member_condition extends ModuleObject
{
	/**
	 * constructor
	 *
	 * @return void
	 */
	public function member_condition()
	{
		if(!Context::isInstalled()) return;

	}

	/**
	 * Implement if additional tasks are necessary when installing
	 *
	 * @return Object
	 */
	public function moduleInstall()
	{
		$oModuleController = getController('module');

		$oModuleController->insertTrigger('member.insertMember', 'member_condition', 'controller', 'triggerInsertMember', 'before');
		$oModuleController->insertTrigger('member.updateMember', 'member_condition', 'controller', 'triggerInsertMember', 'before');
	}

	/**
	 * a method to check if successfully installed
	 *
	 * @return boolean
	 */
	public function checkUpdate()
	{
		$oModuleModel = getModel('module');
		$oModuleController = getController('module');

		if(!$oModuleModel->getTrigger('member.insertMember', 'member_condition', 'controller', 'triggerInsertMember', 'before')) return TRUE;
	}

	/**
	 * Execute update
	 *
	 * @return Object
	 */
	public function moduleUpdate()
	{
		$oModuleModel = getModel('module');
		$oModuleController = getController('module');

		if(!$oModuleModel->getTrigger('member.insertMember', 'member_condition', 'controller', 'triggerInsertMember', 'before'))
			$oModuleController->insertTrigger('member.insertMember', 'member_condition', 'controller', 'triggerInsertMember', 'before');
	}

	/**
	 * Re-generate the cache file
	 *
	 * @return void
	 */
	public function recompileCache()
	{
	}
}
/* End of file member_condition.class.php */
/* Location: ./modules/member_condition/member_condition.class.php */