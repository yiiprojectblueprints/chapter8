<?php

class DashboardModule extends CWebModule
{
	public function init()
	{
        $this->layoutPath = Yii::getPathOfAlias('dashboard.views.layouts');

		// import the module-level models and components
		$this->setImport(array(
			'dashboard.components.*',
		));
		Yii::app()->log->routes[0]->enabled = false; 
        
		Yii::app()->setComponents(array(
            'errorHandler' => array(
            	'errorAction'  => 'dashboard/default/error',
        	)
        ));
	}
}
