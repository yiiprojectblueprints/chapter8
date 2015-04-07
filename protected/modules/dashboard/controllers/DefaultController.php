<?php

class DefaultController extends DashboardController
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
		$model = new Content('search');
		$model->unsetAttributes();

		if (isset($_GET['Content']))
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
			$model = new Content;
		else
			$model = $this->loadModel($id);

		if (isset($_POST['Content']))
		{
			$model->attributes = $_POST['Content'];
			$model->author_id = Yii::app()->user->id;

			if ($model->save())
			{
				Yii::app()->user->setFlash('info', 'The articles was saved');
				$this->redirect($this->createUrl('/dashboard'));
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
		
		$this->redirect($this->createUrl('/dashboard'));
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

		$model = Content::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		return $model;
	}
}