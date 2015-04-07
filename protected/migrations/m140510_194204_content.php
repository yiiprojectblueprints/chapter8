<?php

class m140510_194204_content extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('content', array(
			'id' => 'pk',
			'title' => 'string not null',
			'body' => 'text not null',
			'published' => 'integer DEFAULT 0',
			'author_id' => 'integer',
			'category_id' => 'integer',
			'slug' => 'string not null',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		$this->createTable('categories', array(
			'id' => 'pk',
			'name' => 'string not null',
			'description' => 'text not null',
			'slug' => 'string not null',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		$this->createTable('content_metadata', array(
			'id' 	     => 'pk',
			'content_id' => 'integer',
			'key'        => 'string not null',
			'value'      => 'string not null',
			'created' 		 => 'integer',
			'updated' 		 => 'integer'
		));

		$this->addForeignKey('content_authors', 'content', 'author_id', 'users', 'id', NULL, 'CASCADE', 'CASCADE');
		$this->addForeignKey('content_categories', 'content', 'category_id', 'categories', 'id', NULL, 'CASCADE', 'CASCADE');

		$this->createIndex('content_slug', 'content', 'slug', true);
		$this->createIndex('categories_slug', 'categories', 'slug', true);

		$this->addForeignKey('content_metadata', 'content_metadata', 'content_id', 'content', 'id', NULL, 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		echo "m140510_194204_content does not support migration down.\n";
		return false;
	}
}