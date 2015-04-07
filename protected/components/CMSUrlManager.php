<?php

class CMSUrlManager extends CUrlManager
{
	/**
	 * This is where our defaultRules are stored. This takes the place of the rules array in main.php
	 * This has been moved to here so that we can dynamically update rules without having to worry
	 * making sure the client updates their main.php file on updates.
	 * @var array
	 */
	public $defaultRules = array(
		'/sitemap.xml' 					        => '/content/sitemap',
		'/search/<page:\d+>' 			        => '/content/search',
		'/search' 						        => '/content/search',
		'/blog/<page:\d+>' 				        => '/content/index',
		'/blog' 						        => '/content/index',
		'/' 							        => '/content/index',
    	'/hybrid/<provider:\w+>' 				=> '/hybrid/index',
	);

	/**
	 * Overrides processRules, allowing us to inject our own ruleset into the URL Manager
	 * Takes no parameters
	 **/
	protected function processRules()
	{
		// Generate the clientRules
		$this->rules = !YII_DEBUG ? Yii::app()->cache->get('Routes') : array();
		if ($this->rules == false || empty($this->rules))
		{
			$this->rules = array();
        	$this->rules = $this->generateClientRules();
        	$this->rules = CMap::mergearray($this->addRssRules(), $this->rules);
            $this->rules = CMap::mergearray($this->addModuleRules(), $this->rules);

        	Yii::app()->cache->set('Routes', $this->rules);
        }        

		// Append our cache rules BEFORE we run the defaults
		$this->rules['<controller:\w+>/<action:\w+>/<id:\w+>'] = '<controller>/<action>';
		$this->rules['<controller:\w+>/<action:\w+>'] = '<controller>/<action>';

        return parent::processRules();
	}

    /**
     * Adds rules from the module/config/routes.php file
     * @return
     */
    private function addModuleRules()
    {
        // Load the routes from cache
        $moduleRoutes = array();
        $directories = glob(Yii::getPathOfAlias('application.modules') . '/*' , GLOB_ONLYDIR);

        foreach ($directories as $dir)
        {
            $routePath = $dir .DS. 'config' .DS. 'routes.php';
            if (file_exists($routePath))
            {
                $routes = require_once($routePath);
                foreach ($routes as $k=>$v)
                    $moduleRoutes[$k] = $v;
            }
        }

        return $moduleRoutes;
    }

	/**
     * Generates RSS rules for categories
     * @return array
     */
    private function addRSSRules()
   	{
   		$categories = Category::model()->findAll();
   		foreach ($categories as $category)
   			$routes[$category->slug.'.rss'] = "category/rss/id/{$category->id}";

   		$routes['blog.rss'] = '/category/rss';
   		return $routes;
   	}

   	/**
   	 * Generates client rules, depending on if we want to handle rendering client side or server side
   	 * @return array
   	 */
   	private function generateClientRules()
   	{
    	// Generate the initial rules
		$rules = CMap::mergeArray($this->defaultRules, $this->rules);
    	return CMap::mergeArray($this->generateRules(), $rules);   
   	}

   	/**
   	 * Wrapper function for generation of content rules and category rules
   	 * @return array
   	 */
   	private function generateRules()
   	{
   		return CMap::mergeArray($this->generateContentRules(), $this->generateCategoryRules());
   	}

   	/**
   	 * Generates content rules
   	 * @return array
   	 */
    private function generateContentRules()
    {
    	$rules = array();
    	$criteria = new CDbCriteria;
    	$criteria->addCondition('published = 1');

   		$content = Content::model()->findAll($criteria);
   		foreach ($content as $el)
   		{
   			if ($el->slug == NULL)
   				continue;

   			$pageRule = $el->slug.'/<page:\d+>';
   			$rule = $el->slug;

   			if ($el->slug == '/')
   				$pageRule = $rule = '';

   			$pageRule = $el->slug . '/<page:\d+>';
			$rule = $el->slug;

			$rules[$pageRule] = "content/view/id/{$el->id}";
			$rules[$rule] = "content/view/id/{$el->id}";
   		}

   		return $rules;
    }

    /**
   	 * Generates category rules
   	 * @return array
   	 */
    private function generateCategoryRules()
    {
    	$rules = array();
   		$categories = Category::model()->findAll();
   		foreach ($categories as $el)
   		{
   			if ($el->slug == NULL)
   				continue;

   			$pageRule = $el->slug.'/<page:\d+>';
   			$rule = $el->slug;

   			if ($el->slug == '/')
   				$pageRule = $rule = '';

   			$pageRule = $el->slug . '/<page:\d+>';
			$rule = $el->slug;

			$rules[$pageRule] = "category/index/id/{$el->id}";
			$rules[$rule] = "category/index/id/{$el->id}";
   		}

   		return $rules;
    }
}