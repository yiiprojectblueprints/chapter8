<?php

class FileController extends DashboardController
{
	public function accessRules()
	{
		return CMap::mergeArray(parent::accessRules(), array(
			array('allow',
				'actions' => array('index', 'upload', 'delete'),
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
	 */
	public function actionIndex()
	{
		$model = new ContentMetadata('search');
		$model->unsetAttributes();
		$model->key = 'upload';

		if (isset($_GET['ContentMetadata']))
			$model->attributes = $_GET;

		$this->render('index', array(
			'model' => $model
		));
	}

	/**
	 * Saves a file
	 * @param  int $id
	 */
	public function actionUpload($id = NULL)
	{
		if ($id == NULL)
			throw new CHttpException(400, 'Missing ID');

		if (isset($_FILES['file']))
		{
			$file = new FileUpload($id);

			if ($file->_result['success'])
				Yii::app()->user->setFlash('info', 'The file uploaded to ' . $file->_result['filepath']);
			elseif ($file->_result['error'])
				Yii::app()->user->setFlash('error', 'Error: ' . $file->_result['error']);
			
		}
		else
			Yii::app()->user->setFlash('error', 'No file detected');

		$this->redirect($this->createUrl('/dashboard/default/save?id='.$id));
	}

	/**
	 * Deletes a file
	 * @param  int $id
	 */
	public function actionDelete($id)
	{
		if ($this->loadModel($id)->delete())
		{
			Yii::app()->user->setFlash('info', 'File has been deleted');
			$this->redirect($this->createUrl('/dashboard/file/index'));
		}

		throw new CHttpException(500, 'The server failed to delete the requested file from the database. Please retry');
	}

	/**
	 * Load model method
	 * @param  int $id
	 * @return ContentUpload
	 */
	private function loadModel($id=NULL)
	{
		if ($id == NULL)
			throw new CHttpException(400, 'Missing ID');

		$model = ContentMetadata::model()->findByAttributes(array('id' => $id));
		if ($model == NULL)
			throw new CHttpException(400, 'Object not found');

		return $model;
	}
}