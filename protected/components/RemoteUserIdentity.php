<?php

class RemoteUserIdentity extends CUserIdentity
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
     * The user model
     * @var Users $_user
     */
    public $_user;

    /**
     * The user id
     * @var int $_id
     */
    private $_id;

    /**
     * Override of the constructor to populate the class properly
     * @param array $adapter
     * @param string $provider
     * @param Users $user
     */
    public function __construct($adapter, $provider, $user)
    {
        $this->adapter  = $adapter;
        $this->provider = $provider;
        $this->_user    = $user;
    }

    /**
     * Overload of CiiUserIdentity::getUser to return the user model
     * @return Users $this->_user
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Overload of CiiUserIdentity::authenticate to authenticate the user
     * TODO: Is this secure? We're not really authenticating _anything_ in this class, just using what we have provider
     * @param boolean $force     Unused variable for class extension only
     * @return boolean $this->errorCode
     */
    public function authenticate($force=false)
    {
        // Set the error code first
        $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;

        // Check that the user isn't NULL, or that they're not in a locked state
        if ($this->_user == NULL)
            $this->errorCode = Yii_DEBUG ? self::ERROR_USERNAME_INVALID : self::ERROR_UNKNOWN_IDENTITY;

        // The user has already been provided to us, so immediately log the user in using that information
        $this->errorCode = self::ERROR_NONE;
        $this->_id       = $this->_user->id;
        $this->setState('email', $this->_user->email);
        $this->setState('role', $this->_user->role_id);

        return !$this->errorCode;
    }

    /**
     * Gets the id for Yii::app()->user->id
     * @return int  the user id
     */
    public function getId()
    {
        return $this->_id;
    }
}