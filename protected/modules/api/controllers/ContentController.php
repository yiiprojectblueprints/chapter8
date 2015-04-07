<?php

class ContentController extends ApiController
{
	/**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {   
        return array(
        	array('allow',
        		'actions' => array('index'),
        	),
            array('allow',
                'actions' => array('indexDelete', 'indexPost'),
                'expression' => '$user!=NULL&&$user->role->id==2'
            ),
            array('deny') 
        );  
    }

    /**
     * [GET] [/content/<id>]
     * @return array    List of content
     */
    public function actionIndex($id=NULL)
    {
        if ($id !== NULL)
        {
            $content = $this->loadModel($id);
            if ($content == NULL)
                throw new CHttpException(404, 'A content with the id was not found.');

            return $content->getAPIAttributes();
        }
        
        $model = new Content('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['content']))
            $model->attributes = $_GET['content'];

        // Modify the pagination variable to use page instead of content page
        $dataProvider = $model->search();
        $dataProvider->pagination = array(
            'pageVar' => 'page'
        );

        // Throw a 404 if we exceed the number of available results
        if ($dataProvider->totalItemCount == 0 || ($dataProvider->totalItemCount / ($dataProvider->itemCount * Yii::app()->request->getParam('page', 1))) < 1)
            throw new CHttpException(404, 'No results found');

        $response = array();

        foreach ($dataProvider->getData() as $content)
            $response[] = $content->getAPIAttributes();

        return $response;
    }

    /**
     * [POST] [/content/<id>]
     * @return array    content
     */
    public function actionIndexPost($id=NULL)
    {
        if ($id === NULL)
            $content = new Content;
        else
        {
            $content = $this->loadModel($id);
            if ($content == NULL)
                throw new CHttpException(404, 'A content with the id of was not found.');
        }
        
        $content->attributes = $_POST;

        if ($content->isNewRecord)
            $content->author_id = $this->user->id;
        
        if ($content->save())
            return $content->getAPIAttributes(array());

        return $this->returnError(400, NULL, $content->getErrors());         
    }

	/**
     * [DELETE] [/content/<id>]
     * @return boolean
     */
    public function actionIndexDelete($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'A content id must be specified to delete.');
        
        $content = $this->loadModel($id);
        if ($content == NULL)
            throw new CHttpException(404, 'A content with the id of was not found.');

        if ($content->id == 1)
            throw new CHttpException(400, 'The root content cannot be deleted.');

        return $content->delete();
    }

	/**
	 * Load Model method
	 * @param  int $id
	 * @return content $model
	 */
	private function loadModel($id=NULL)
	{
		if ($id == NULL)
			throw new CHttpException(404, 'No content with that ID exists');

		$model = Content::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No content with that ID exists');

		return $model;
	}
}