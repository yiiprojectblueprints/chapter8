<?php

/**
 * @class RemoteRegistrationForm
 * @see protected/models/RegistrationForm.php
 *
 * This class extends RegisterForm to take advantage of all the work that is already being done there.
 * Data in this form is validated against the parent class, and then the identity is bound to the user new
 */
class RemoteRegistrationForm extends RegistrationForm
{
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
     * Validation rules that overload RegisterForm's validation rules
     * @return array
     */
    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('adapter, provider', 'required')
        ));
    }

    /**
     * Calls the RegisterForm::save(false) method and doesn't send an email
     * @return boolean
     */
    public function save($sendEmail = false)
    {
        // If the parent form saved and validated
        if (parent::save())
        {
            // Then bind the identity to this user permanently
            $meta = new UserMetadata;
            $meta->attributes = array(
                'user_id' => $this->_user->id,
                'key' => $this->provider.'Provider',
                'value' => $this->adapter->identifier
            );

            // Save the associative object
            return $meta->save();
        }

        return false;
    }
}