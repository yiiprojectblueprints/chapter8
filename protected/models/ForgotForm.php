<?php

/**
 * This form handles and initiates a forgot password process for the user
 * It first validates that the user exists, then creates a new activation_key for that user and sets the activation_id to -1
 */
class ForgotForm extends CFormModel
{
	/**
	 * @var string $email 	The email address of the user
	 */
	public $email;

	/**
	 * @var User $_user 	The validated user
	 */
	private $_user;

	/**
	 * Validate rules
	 */
	public function rules()
	{
		return array(
			// Email is Required, and must be an email
			array('email', 'required'),
			array('email', 'email'),

			// Email must also belong to an existing user
			array('email', 'checkUser'),
		);
	}

    /**
     * Model Attribute Labels
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email' => 'Your Email Address'
        );
    }

	/**
	 * Validates that the email belongs to a user
	 * @param string $attribute The attribute
	 * @param array  $params 	The parameters belonging to the attribute
	 * @return boolean
	 */
	public function checkUser($attribute,$params)
	{
		$this->_user = User::model()->findByAttributes(array('email' => $this->email));

		if ($this->_user == NULL)
		{
			$this->addError('email', 'There is no user in our system with that email address.');
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

		// Set the activation details
		$this->_user->generateActivationKey();
		$this->_user->activated = -1;

		if ($this->_user->save())
		{
			$sendgrid = new SendGrid(Yii::app()->params['includes']['sendgrid']['username'], Yii::app()->params['includes']['sendgrid']['password']);
			$email    = new SendGrid\Email();

			$email->setFrom(Yii::app()->params['includes']['sendgrid']['from'])
				->addTo($this->_user->email)
				->setSubject('Reset Your Socialii Password')
				->setText('Reset Your Socialii Password')
				->setHtml(Yii::app()->controller->renderPartial('//email/forgot', array('user' => $this->_user), true));

			// Send the email
			$sendgrid->send($email);

			return true;
		}
		else
			$this->addError('email', 'Unable to send reset link. This is likely a temporary error. Please try again in a few minutes.');

		return false;
	}
}
