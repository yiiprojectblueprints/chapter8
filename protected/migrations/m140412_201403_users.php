<?php

class m140412_201403_users extends CDbMigration
{
	// Abstract Column types
	// http://www.yiiframework.com/doc/api/1.1/CDbSchema#getColumnType-detail
	public function safeUp()
	{
		// Create the Roles table
		$this->createTable('roles', array(
			'id' 		=> 'pk',
			'name' 		=> 'string',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		// Create the users table
		$this->createTable('users', array(
			'id' 			 => 'pk',
            'username'       => 'string',
			'email'	 	 	 => 'string not null',
			'new_email' 	 => 'string',
			'password' 		 => 'string not null',
			'name' 			 => 'string not null',
			'activation_key' => 'string',
			'activated' 	 => 'integer',
			'role_id'		 => 'integer',
			'created' 		 => 'integer',
			'updated' 		 => 'integer'
		));

		$this->createTable('user_metadata', array(
			'id' 	  => 'pk',
			'user_id' => 'integer',
			'key'     => 'string not null',
			'value'   => 'string not null',
			'created' 		 => 'integer',
			'updated' 		 => 'integer'
		));

		// Create a unique index on the email column
		$this->createIndex('email_index', 'users', 'email', true);
        $this->createIndex('username_index', 'users', 'username', true);

		// Create a Foreign key on users::role_id -> roles::id
		$this->addForeignKey('user_roles', 'users', 'role_id', 'roles', 'id', NULL, 'CASCADE', 'CASCADE');

		// Create a Foreign key on user_metadata::user_id -> users::id
		$this->addForeignKey('user_metadata', 'user_metadata', 'user_id', 'users', 'id', NULL, 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		return false;
	}
}
