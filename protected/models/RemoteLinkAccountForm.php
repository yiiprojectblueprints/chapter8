<?php

class RemoteLinkAccountForm extends CFormModel
{
    /**
     * The user's current password
     * @var string $password
     */
    public $password;

    /**
     * HybridAuth::DefaultController::$adapter->getUserProfile()
     * @var array $adapter
     */
    public $adapter;

    /**
     * The provider name
     * @var string $provider
     */
    public $provider;

    /**
     * User model
     * @param Users $_user
     */
    private $_user;

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return array(
            array('password, adapter, provider', 'required'),
            array('password', 'validateUserPassword')
        );
    }

    public function attributeLabels()
    {
        return array(
            'password' => 'Your Current Password'
        );
    }

    /**
     * Ensures that the password entered matches the one provided during registration
     * @param array $attributes
     * @param array $params
     * return array
     */
    public function validateUserPassword($attributes, $params)
    {
        $this->_user = User::model()->findByPk(Yii::app()->user->id);
        
        if ($this->_user == NULL)
        {
            $this->addError('password', 'Unable to identify user.');
            return false;
        }

        $result = password_verify($this->password, $this->_user->password);

        if ($result == false)
        {
            $this->addError('password', 'The password you entered is invalid.');
            return false;
        }

        return true;
    }

    /**
     * Bind's the user identity to the mdoel
     * @return boolean
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        $meta = new UserMetadata;
        $meta->attributes = array(
            'user_id' => $this->_user->id,
            'key' => $this->provider.'Provider',
            'value' => (string)$this->adapter->identifier
        );

        // Save the associative object
        return $meta->save();
    }
}