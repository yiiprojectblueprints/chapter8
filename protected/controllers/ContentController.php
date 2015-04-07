<?php

class ContentController extends CMSController
{
	/**
	 * Layout
	 * @var string $layout
	 */
	public $layout = 'default';

	/**
	 * AccessControl filter
	 * @return array
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * AccessRules
	 * @return array
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'view', 'search'),
				'users' => array('*')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Verifies that our request does not produce duplicate content (/about == /content/index/2), and prevents direct access to the controller action
	 * protecting it from possible attacks.
	 * Better for SEO to prevent duplicate contents
	 * @param $id	- The content ID we want to verify before proceeding
	 **/
	private function beforeViewAction($id=NULL)
	{
		// If we do not have an ID, consider it to be null, and throw a 404 error
		if ($id == NULL)
			throw new CHttpException(404,'The specified post cannot be found.');
		
		// Retrieve the HTTP Request
		$r = new CHttpRequest();
		
		// Retrieve what the actual URI
		$requestUri = str_replace($r->baseUrl, '', $r->requestUri);
		
		// Retrieve the route
		$route = '/' . $this->getRoute() . '/' . $id;
		$requestUri = preg_replace('/\?(.*)/','',$requestUri);
		
		// If the route and the uri are the same, then a direct access attempt was made, and we need to block access to the controller
		if ($requestUri == $route)
			throw new CHttpException(404, 'The requested post cannot be found.');
        
        return str_replace($r->baseUrl, '', $r->requestUri);
	}

	/**
	 * Displays all the posts on the site in a paginated view
	 */
	public function actionIndex($page=1)
	{
		$this->setPageTitle('All Content');	
		
		// Model Search without $_GET params
		$model = new Content('search');
		$model->unsetAttributes();
		$model->published = 1;

		$this->render('//content/all', array(
			'dataprovider' => $model->search()
		));
	}

	/**
	 * Viewing of a particular article by it's slug
	 * @param  int $id
	 */
	public function actionView($id=NULL)
	{
		Yii::app()->user->setReturnUrl($this->beforeViewAction($id));
        
		// Retrieve the data
		$content = Content::model()->findByPk($id);

		// beforeViewAction should catch this
		if ($content == NULL || !$content->published)
			throw new CHttpException(404, 'The article you specified does not exist.');
		
		$this->setPageTitle($content->title);

		$this->render('view', array(
			'id'   => $id, 
			'post' => $content
		));
	}

	/**
	 * Provides functionality for searching through our database
	 */
	public function actionSearch()
	{
		$param = Yii::app()->request->getParam('q');

		$criteria = new CDbCriteria;

        $criteria->addSearchCondition('title',$param,'OR');
        $criteria->addSearchCondition('body',$param,'OR');

        $dataprovider = new CActiveDataProvider('Content', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 5,
                'pageVar'=>'page'
            )
        ));

        $this->render('//content/all', array(
			'dataprovider' => $dataprovider
		));
	}

	/**
     * Provides basic sitemap functionality via XML
     */
	public function actionSitemap()
	{
		Yii::app()->log->routes[0]->enabled = false; 

		ob_end_clean();
		header('Content-type: text/xml; charset=utf-8');
		
		$this->layout = false;

		$content = Content::model()->findAllByAttributes(array('published' => 1));
		$categories = Category::model()->findAll();
		$this->renderPartial('sitemap', array(
			'content'		=> $content, 
			'categories'	=> $categories, 
			'url' 			=> 'http://'.Yii::app()->request->serverName . Yii::app()->baseUrl
		));
	}
}