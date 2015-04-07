<?php

/**
 * This form handles the changing of sensative user information
 */
class ProfileForm extends CFormModel
{
	/**
	 * @var string $email 	    The email address of the user
	 */
	public $email;

	/**
	 * @var string $password 	The user's CURRENT password (required for all fields)
	 */
	public $password;

    /**
	 * @var string $email 	    The user's name
	 */
	public $name;

    /**
	 * @var string $email 	    The user's new password, if requested
	 */
	public $newpassword = NULL;

    /**
	 * @var string $email 	    The user's new password, repeated, if requested
	 */
	public $newpassword_repeat = NULL;

    /**
     * @var User $user          The User model - populated by verifyPassword
     */
    private $_user;

	/**
	 * Validate rules
	 */
	public function rules()
	{
		return array(
			// Email is Required, and must be an email
			array('email, name, password', 'required'),
			array('newpassword', 'length', 'min' => 8),
			array('email', 'email'),
            array('password', 'verifyPassword'),

            // Validation will pass if this is NULL
            array('newpassword', 'compare', 'compareAttribute' => 'newpassword_repeat')
		);
	}

    /**
     * Form attribute labels
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email'               => 'Your New Email Address',
            'password'            => 'Your Current Password',
            'name'                => 'Your Name',
            'newpassword'         => 'Your NEW password',
            'newpassword_repeat'  => 'Your NEW password (again)'
        );
    }

	/**
	 * Validates that a user is who they say they compare
	 * @param string $attribute The attribute
	 * @param array  $params 	The parameters belonging to the attribute
	 * @return boolean
	 */
	public function verifyPassword($attribute,$params)
	{
		// Only allow change requests from the currently logged inuser
		$this->_user = User::model()->findByPk(Yii::app()->user->id);

		// User doesn't exist. Something bad has happened
		if ($this->_user == NULL)
			return false;

		// NULL the new password if it isn't set
		if ($this->newpassword == '' || $this->newpassword == NULL)
			$this->newpassword == NULL;

		// Validate the password
		if (!password_verify($this->password, $this->_user->password))
		{
			$this->addError('password', 'The password you entered is invalid');
			return false;
		}
		return true;
	}

	/**
	 * Saves the user's activation_key, and sends an email to the user with a link they can use to reset their password
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		// Set the user attributes
		$this->_user->attributes = array(
			// If the email submitted is different than the current email, change the new_email field
			'new_email' => $this->email == $this->_user->email ? NULL : $this->email,

			// Set the new password if validation passes
			'password' => $this->newpassword == NULL ? NULL : $this->newpassword,
			'name' => $this->name
		);

		// Save the user's information
		if ($this->_user->save())
		{
			// If the user's password has changed, send the user an email so that they can be aware of it
			if ($this->newpassword != NULL && $this->password != $this->newpassword)
				$this->sendPasswordChangeNotification();

			// If the user entered a NEW email address, and we haven't already sent them a change email notification
			// Send them a change email notification
			if ($this->email != $this->_user->_oldAttributes['email'] && $this->_user->activated != -2)
				$this->sendEmailChangeNotification();

			return true;
		}

		return false;
	}

    /**
     * Sends a password change notification to the user
     * return boolean
     */
    private function sendPasswordChangeNotification()
    {
        $sendgrid = new SendGrid(Yii::app()->params['includes']['sendgrid']['username'], Yii::app()->params['includes']['sendgrid']['password']);
        $email    = new SendGrid\Email();

        $email->setFrom(Yii::app()->params['includes']['sendgrid']['from'])
            ->addTo($this->_user->email)
            ->setSubject("Your Socialii Password Has Been Changed")
            ->setText('Your Socialii Password Has Been Changed')
            ->setHtml(Yii::app()->controller->renderPartial('//email/passwordchange', array('user' => $this->_user), true));

        // Send the email
        return $sendgrid->send($email);
    }

    /**
     * Sends a email change notification to the NEW email address - and require them to verify their email
     * @return boolean
     */
    private function sendEmailChangeNotification()
    {
        // Change the user's activation status for the verification link
        $this->_user->activated = -2;
        $this->_user->activation_key = $this->_user->generateActivationKey();

        // Save the user's information
        if ($this->_user->save())
        {
            $sendgrid = new SendGrid(Yii::app()->params['includes']['sendgrid']['username'], Yii::app()->params['includes']['sendgrid']['password']);
            $email    = new SendGrid\Email();

            $email->setFrom(Yii::app()->params['includes']['sendgrid']['from'])
                ->addTo($this->_user->new_email)
                ->setSubject("Verify Your New Email Address")
                ->setText('Verify Your New Email Address')
                ->setHtml(Yii::app()->controller->renderPartial('//email/verify', array('user' => $this->_user), true));

            // Send the email
            return $sendgrid->send($email);
        }

        return false;
    }
}
