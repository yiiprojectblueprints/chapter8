<?php

class HybridController extends CMSController
{
    /**
     * The Provider name
     * @var string $_provider
     */
    protected $_provider;

    /**
     * The HybridAuth Adapter
     * @var HybridAdapter $adapter
     */
    private $_adapter = NULL;

    /**
     * The profile data
     * @param array $_userProfile
     */
    private $_userProfile = NULL;

    /**
     * Retrieves the HybridAuth session ID
     * @return mixed
     */
    private function getSession()
    {
        if (isset($_SESSION['HA::CONFIG']['php_session_id']))
            return unserialize($_SESSION['HA::CONFIG']['php_session_id']);

        return false;
    }

    /**
     * Sets the HybridAuth adapter
     * @param Hybrid_Provider_Adapter $adapter
     * @return Hybrid_Provider_Adapter
     */
    public function setAdapter($adapter)
    {
        return $this->_adapter = $adapter;
    }

    /**
     * Retrieves the HybridAuth Adapter from $_SESSION
     * Don't call getAdapter before setAdapter. Bad vudo if you do
     * @return Hybrid_Provider_Adapter
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    /**
     * Caches the getUserProfile request to prevent rate limiting issues.
     * @return object
     */
    public function getUserProfile()
    {
        if ($this->_userProfile == NULL)
            $this->_userProfile = $this->getAdapter()->getUserProfile();

        return $this->_userProfile;
    }

    /**
     * Sets the provider for this controller to use
     * @param string $provider The Provider Name
     * @return $provider
     */
    public function setProvider($provider=NULL)
    {
        // Prevent the provider from being NULL
        if ($provider == NULL)
            throw new CException("You haven't supplied a provider");

        // Set the property
        $this->_provider = $provider;

        return $this->_provider;
    }

    /**
     * Retrieves the provider name
     * @return string $this->_provider;
     */
    public function getProvider()
    {
        return $this->_provider;
    }

    /**
     * Configuration file for HybridAuth
     * @return [type] [description]
     */
    public function getConfig()
    {
        return array(
            'baseUrl' => Yii::app()->getBaseUrl(true),
            'base_url' => Yii::app()->getBaseUrl(true) . '/hybrid/callback', // URL for Hybrid_Auth callback
            'debug_mode' => YII_DEBUG,
            'debug_file' => Yii::getPathOfAlias('application.runtime.hybridauth').'.log',
            'providers' => Yii::app()->params['includes']['hybridauth']['providers']
        );
    }

	/**
	 * Disable filters. This should always return a valid non 304 response
	 */
	public function filters()
	{
		return array();
	}

    /**
     * Initialization path
     * @param string $provider     The HybridAuth provider
     * @return void
     */
	public function actionIndex($provider=NULL)
	{
        // Set the provider
        $this->setProvider($provider);

        if (isset($_GET['hauth_start']) || isset($_GET['hauth_done']))
            Hybrid_Endpoint::process();

        try {
		    $this->hybridAuth();
        } catch (Exception $e) {
            throw new CHttpException(400, $e->getMessage());
        }
	}

	/**
     * Handles authenticating the user against the remote identity
	 */
	private function hybridAuth()
	{
        // Preload some configuration options
        if (strtolower($this->getProvider()) == 'openid')
		{
			if (!isset($_GET['openid-identity']))
				throw new CException("You chose OpenID but didn't provide an OpenID identifier");
			else
				$params = array("openid_identifier" => $_GET['openid-identity']);
		}
		else
			$params = array();

        // Load HybridAuth
        $hybridauth = new Hybrid_Auth($this->getConfig());

        if (!$this->adapter)
            $this->setAdapter($hybridauth->authenticate($this->getProvider(),$params));

        // Proceed if we've been connected
        if ($this->adapter->isUserConnected())
		{
            // If we have an identity on file, then autheticate as that user.
            if ($this->authenticate())
            {
                Yii::app()->user->setFlash('success', 'You have been sucessfully logged in!');

                $this->redirect(Yii::app()->getBaseUrl(true));
            }
            else
            {
                // If we DON'T have information about this user already on file
                // If they're not a guest, present them with a form to link their accounts
                // Otherwise present them with a registration form
                // We want remote users to have their own identity, rather than just dangling and not being able to actually interact with our site
                if (!Yii::app()->user->isGuest)
                    $this->renderLinkForm();
                else
                    $this->renderRegisterForm();
            }
        }
        else
            throw new CHttpException(403, 'Failed to establish remote identity');
	}

    /**
     * Authenticates in as the user
     * @return boolean
     */
    private function authenticate()
    {
        $form = new RemoteIdentityForm;
        $form->attributes = array(
            'adapter'  => $this->getUserProfile(),
            'provider' => $this->getProvider()
        );

        return $form->login();
    }

    /**
     * Renders the linking form
     */
    private function renderLinkForm()
    {
        $form = new RemoteLinkAccountForm;

        if (Yii::app()->request->getParam('RemoteLinkAccountForm'))
        {
            // Populate the model
            $form->Attributes = Yii::app()->request->getParam('RemoteLinkAccountForm');
            $form->provider   = $this->getProvider();
            $form->adapter    = $this->getUserProfile();

            if ($form->save())
            {
                if ($this->authenticate())
                {
                    Yii::app()->user->setFlash('success', 'You have been successfully logged in');
                    $this->redirect($this->createAbsoluteUrl('content/index'));
                }
            }
        }

        // Reuse the register form
        $this->render('//user/linkaccount', array('model' => $form));
    }

    /**
     * Provides functionality to register a user from a remote user identity
     * This method reuses the //site/register form and the RegisterForm model
     */
    private function renderRegisterForm()
    {
        $form = new RemoteRegistrationForm;

        if (Yii::app()->request->getParam('RemoteRegistrationForm'))
        {
            // Populate the model
            $form->attributes = Yii::app()->request->getParam('RemoteRegistrationForm');
            $form->provider   = $this->getProvider();
            $form->adapter    = $this->getUserProfile();

            if ($form->save())
            {
                if ($this->authenticate())
                {
                    Yii::app()->user->setFlash('success', 'You have been successfully logged in');
                    $this->redirect($this->createUrl('content/index'));
                }
            }
        }

        // Reuse the register form
        $this->render('//user/register', array('user' => $form));
    }
}
