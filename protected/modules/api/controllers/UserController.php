<?php

class UserController extends ApiController
{
	/**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {   
        return array(
        	array('allow',
        		'actions' => array('tokenPost', 'registerPost', 'activate', 'forgotPost', 'verifyPost', 'resetPasswordPost'),
        	),
        	array('allow',
        		'actions' => array('tokenDelete'),
        		'expression' => '$user!=NULL'
        	),
            array('allow',
                'actions' => array('index', 'indexPost'),
                'expression' => '$user!=NULL&&($user->role->id==2||Yii::app()->request->getParam("id")==$user->id)'
            ),
            array('allow',
                'actions' => array('indexDelete'),
                'expression' => '$user!=NULL&&$user->role->id==2'
            ),
            array('deny') 
        );  
    }

    /**
     * [POST] [/user/token]
     * Allows for the generation of new API Token
     * @return array
     */
    public function actionTokenPost()
    {
    	$model = new LoginForm;
    	$model->username = Yii::app()->request->getParam('email', NULL);
    	$model->password = Yii::app()->request->getParam('password', NULL);

    	if ($model->validate())
    	{
    		if ($model->login())
    		{
    			// If the model validated, we have a user
    			$user = User::model()->findByAttributes(array('email' => $model->username));
    			$token = UserMetadata::model()->findByAttributes(array(
                    'user_id' => $user->id,
                    'key' => 'api_key'
                ));

                if ($token == NULL)
                    $token = new UserMetadata;

    			$token->attributes = array(
    				'user_id' => $user->id,
    				'key' => 'api_key',
    				'value' => $user->generateActivationKey() // Reuse this method for cryptlib
    			);

    			if ($token->save())
    				return $token->value;

    			// Fall through to 403 if save failed
    		}
    	}

        return $this->returnError(401, $model->getErrors(), null);
    }

    /**
     * [DELETE] [/user/token]
     * Allows for the deletion of the active API token
     * @return array
     */
    public function actionTokenDelete()
    {
    	$model = UserMetadata::model()->findByAttributes(array('user_id' => $this->user->id, 'value' => $this->xauthtoken));

    	if ($model === NULL)
    		throw new CHttpException(500, 'An unexpected error occured while deleting the token. Please re-generate a new token for subsequent requests.');
    	return $model->delete();
    }

    /**
     * [POST] [/user/register]
     * Registers a new user
     * @return boolean
     */
    public function actionRegisterPost()
    {
        $form = new RegistrationForm;
        $form->attributes = $_POST;

        if ($form->save())
            return true;
        else
            return $this->returnError(400, $form->getErrors(), null);
    }

    /**
     * [GET] [/user/verify]
     * Verifies a user's new email address
     * @return boolean
     */
    public function actionVerifyPost($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Activation ID is missing');

        $user = User::model()->findByAttributes(array('activation_key' => $id));

        if ($user == NULL)
            throw new CHttpException(400, 'The verification ID you supplied is invalid');

        $user->attributes = array(
            'email' => $user->new_email,
            'new_email' => NULL,
            'activated' => 1,
            'activation_key' => NULL
        );

        if ($user->save())
            return true;
        else
            return $this->returnError(400, $user->getErrors(), null);
    }

    /**
     * [GET] [/user/activate]
     * Activates a user
     * @return boolean
     */
    public function actionActivate($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Activation ID is missing');

        $user = User::model()->findByAttributes(array('activation_key' => $id));

        if ($user == NULL)
            throw new CHttpException(400, 'The activation ID you supplied is invalid');

        // Don't allow activations of users who have a password reset request OR have a change email request in
        // Email Change Requests and Password Reset Requests require an activated account
        if ($user->activated == -1 || $user->activated == -2)
            throw new CHttpException(400, 'There was an error fulfilling your request');

        $user->activated = 1;
        $user->password = NULL;           // Don't reset the password
        $user->activation_key = NULL;     // Prevent reuse of their activation key

        if ($user->save())
            return true;
        else
            return $this->returnError(400, $user->getErrors(), null);

        throw new CHttpException(500, 'An error occuring activating your account. Please try again later');
    }

    /**
     * [POST] [/user/forgot]
     * Forgot Password functionality
     * @return boolean
     */
    public function actionForgotPost()
    {
        $form = new ForgotForm;

        $form->attributes = $_POST;

        if ($form->save())
            return true;
        else
            return $this->returnError(400, $form->getErrors(), null);
    }

    /**
     * [POST] [/user/resetpassword]
     * Password Reset functionality
     * @return boolean
     */
    public function actionResetPasswordPost($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Missing Password Reset ID');

        $user = User::model()->findByAttributes(array('activation_key' => $id));

        if ($user == NULL)
            throw new CHttpException(400, 'The password reset id you supplied is invalid');

        $form = new PasswordResetForm;

        $form->attributes = array(
            'user'            => $user,
            'password'        => Yii::app()->getParam($_POST, 'password'], ''),
            'password_repeat' => Yii::app()->getParam($_POST, 'password_repeat', '')
        );

        if ($form->save())
            return true;
        else
            return $this->returnError(400, $form->getErrors(), null);
    }

    /**
     * [POST] [/user/index]
     * Creates or updates a user, depending upon their permissions
     * @param  int $id    The User ID
     * @return User
     */
    public function actionIndexPost($id=NULL)
    {
        if ($id == NULL)
            return $this->createUser();
        else
            return $this->updateUser($id);
    }

    /**
     * [DELETE] [/user/index]
     * Deletes a user
     * @param  int $id    The User ID
     * @return User
     */
    public function actionIndexDelete($id=NULL)
    {
        if ($id == $this->user->id)
             return $this->returnError(401, 'You cannot delete yourself', null);

         return $this->loadModel($id)->delete();
    }

    /**
     * [GET] [/user/index]
     * Returns information about a user if they are authenticated or an admin
     * @param  int $id    The User ID
     * @return User
     */
    public function actionIndex($id=NULL)
    {
        if ($id !== NULL)
        {
            if ($this->user->role->id != 2 && $this->user->id != $id)
               throw new CHttpException(403, 'You do not have access to this resource');

            return $this->loadModel($id)->getApiAttributes(array('password'), array('role', 'metadata'));
        }
        
        if ($this->user->role->id != 2)
            throw new CHttpException(403, 'You do not have access to this resource');

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];

        // Modify the pagination variable to use page instead of User page
        $dataProvider = $model->search();
        $dataProvider->pagination = array(
            'pageVar' => 'page'
        );

        // Throw a 404 if we exceed the number of available results
        if ($dataProvider->totalItemCount == 0 || ($dataProvider->totalItemCount / ($dataProvider->itemCount * Yii::app()->request->getParam('page', 1))) < 1)
            throw new CHttpException(404, 'No results found');

        $response = array();

        foreach ($dataProvider->getData() as $user)
            $response[] = $user->getAPIAttributes(array('password'), array('role', 'metadata'));

        return $response;   
    }

    /**
     * Creates a new user using the provided POST credentials
     * @return array
     */
    private function createUser()
    {
        if ($this->user->role->id != 2)
            throw new CHttpException(403, 'You do not have access to this resource');

        $model = new User;
        $model->attributes = $_POST;

        if ($model->save())
            return User::model()->findByPk($model->id)->getApiAttributes(array('password'), array('role', 'metadata'));
        else
            return $this->returnError(400, $model->getErrors(), null);
    }

    /**
     * Updates a user record
     * @param  int $id    The User ID
     * @return User
     */
    private function updateUser($id=NULL)
    {
        if ($this->user->role->id != 2 && $this->user->id != $id)
            throw new CHttpException(403, 'You do not have permission to modify this user');

        $model = $this->loadModel($id);

        $model->attributes = $_POST;

        if ($model->save())
             return User::model()->findByPk($model->id)->getApiAttributes(array('password'), array('role', 'metadata'));
        else
            return $this->returnError(400, $model->getErrors(), null);
    }

    /**
     * Load model method
     * @param  int $id    The User ID
     * @return User
     */
    private function loadModel($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Missing ID');

        $model = User::model()->findByPk($id);

        if ($model == NULL)
            throw new CHttpException(400, 'User not found');

        return $model;
    }
}
