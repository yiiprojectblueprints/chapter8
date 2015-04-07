<?php

class DisqusWidget extends CWidget
{
	public $shortname = NULL;

	public $identifier = NULL;

	public $url = NULL;

	public $title = NULL;

	public function init()
	{
		parent::init();
		if ($this->shortname == NULL)
			throw new CHttpException(500, 'Disqus shortname is required');
		
		echo "<div id='disqus_thread'></div>";
		Yii::app()->clientScript->registerScript('disqus', "
			 var disqus_shortname = '{$this->shortname}';
			 var disqus_identifier = '{$this->identifier}';
			 var disqus_url = '{$this->url}';
			 var disqus_title = '{$this->title}';

	        /* * * DON'T EDIT BELOW THIS LINE * * */
	        (function() {
	            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
	            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	        })();
		");
	}
}