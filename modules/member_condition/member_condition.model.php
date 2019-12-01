<?php
/* Copyright (C) Jiyong Youn */
/**
 * @class  member_conditionModel
 * @author Jiyong Youn
 * @brief model class of the member_condition module
 */
class member_conditionModel extends member_condition
{
	/**
	 * @brief Return module setting
	 */
	public function getMember_conditionConfig()
	{
		$oModuleModel = getModel('module');
		$member_condition_config = $oModuleModel->getModuleConfig('member_condition');
		if(!is_object($member_condition_config))
		{
			$member_condition_config = new stdClass();
		}

		return $member_condition_config;
	}
}
/* End of file member_condition.model.php */
/* Location: ./modules/member_condition/member_condition.model.php */