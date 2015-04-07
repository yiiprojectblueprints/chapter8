<?php

class CMSSLugActiveRecord extends CMSActiveRecord
{
	public function validateSlug($attributes, $params)
	{
		// Fetch any records that have that slug
		$content = Content::model()->findByAttributes(array('slug' => $this->slug));
		$category = Category::model()->findByAttributes(array('slug' => $this->slug));

		$class = strtolower(get_class($this));

		if ($content == NULL && $category == NULL)
			return true;
		else
		{
			if ($this->id == $$class->id)
				return true;
		}
		
		$this->addError('slug', 'That slug is already in use');
		return false;
	}

	public function afterSave()
	{
		if (!YII_DEBUG)
			Yii::app()->cache->delete('Routes');
		
		parent::afterSave();
	}
}