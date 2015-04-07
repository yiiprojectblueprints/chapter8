<?php

/**
 * This form handles the password reset process for the user
 * It first validates the user's new password,
 */
class PasswordResetForm extends CFormModel
{
	/**
	 * @var string $password 	The users new password
	 */
	public $password;

	/**
	 * @var string $password2 	The users new password (again)
	 */
	public $password_repeat;

	/**
	 * @var User $_user 	The validated user
	 */
	public $user;

	/**
	 * Validate rules
	 */
	public function rules()
	{
		return array(
			array('password', 'length', 'min' => 8),
			array('password, password_repeat, user', 'required'),
			array('password', 'compare', 'compareAttribute' => 'password_repeat'),
		);
	}

	/**
	 * Resets the user's password
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$this->user->password = $this->password;

		// Verify that this activation key can't be used again
		$this->user->activated = 1;
		$this->user->activation_key = NULL;

		if ($this->user->save())
			return true;

		return false;
	}
}
