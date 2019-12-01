<?php
/* Copyright (C) Jiyong Youn */
/**
 * @class  member_conditionController
 * @author Jiyong Youn
 * @brief controller class of the member_condition module
 */
class member_conditionController extends member_condition
{
	/**
	 * @brief Initialization
	 */
	public function init()
	{
	}

	/**
	 * @brief member_condition module trigger in Member module
	 */
	public function triggerInsertMember(&$obj)
	{
		// 설정 가져오기
		$oMember_conditionModel = getModel('member_condition');
		$member_condition_config = $oMember_conditionModel->getMember_conditionConfig();

		if($member_condition_config->answer)
		{
			$answer = $member_condition_config->answer;
			$answer_user = Context::get('answer');
			$blocked = TRUE;
			if($answer === $answer_user)
			{
				$blocked = FALSE;
			}
			if($blocked === TRUE)
			{
				$description_text = sprintf(Context::getLang('member_condition_question_blocked'), $member_condition_config->answer);
				return $this->stop($description_text);
			}
		}
		//return new Object();
	}
}
/* End of file member_condition.controller.php */
/* Location: ./modules/member_condition/member_condition.controller.php */