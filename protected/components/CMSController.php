<?php

class CMSController extends CController
{
	/**
	 * Sets the theme
	 * @param  CInlineAction $action
	 * @return CController::beforeAction() || true
	 */
	public function beforeAction($action)
	{
		Yii::app()->setTheme('main');
		return parent::beforeAction($action);
	}
}