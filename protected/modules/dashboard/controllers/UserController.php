<?php

class UserController extends DashboardController
{

	public function accessRules()
	{
		return CMap::mergeArray(parent::accessRules(), array(
			array('allow',
				'actions' => array('index', 'save', 'delete'),
				'users'=>array('@'),
				'expression' => 'Yii::app()->user->role==2'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			)
		));
	}	

	/**
	 * Admin for listing content
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$model = new User('search');
		$model->unsetAttributes();

		if (isset($_GET['User']))
			$model->attributes = $_GET;

		$this->render('index', array(
			'model' => $model
		));
	}

	/**
	 * Created/Update an existing article
	 * @param  int $id
	 */
	public function actionSave($id=NULL)
	{
		if ($id == NULL)
			$model = new User;
		else
			$model = $this->loadModel($id);

		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];

			if ($model->save())
			{
				Yii::app()->user->setFlash('info', 'The user was saved');
				$this->redirect($this->createUrl('/dashboard/user'));
			}
		}

		$this->render('save', array(
			'model' => $model
		));
	}

	/**
	 * Delete action
	 * @param  int $id
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		$this->redirect($this->createUrl('/dashboard/user'));
	}

	/**
	 * Load Model method
	 * @param  int $id
	 * @return Category $model
	 */
	private function loadModel($id=NULL)
	{
		if ($id == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		$model = User::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		return $model;
	}
}