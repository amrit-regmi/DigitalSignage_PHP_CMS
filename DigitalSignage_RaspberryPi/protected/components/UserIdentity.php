<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_USER_NOT_ACTIVE=3;
    const ERROR_USER_DELETED = 4;
    const ERROR_USERNAME_INVALID=2;
    private $_id;
    public $_username;
    
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        // try to find user by username
        $user = Users::model()->findByAttributes(array('username' => $this->username));
        if ($user === NULL) {
            // try to find user by its email address...
            $user = Users::model()->findByAttributes(array('email' => $this->username));
        }
        
        if ($user === NULL || $user->deleted || !$user->Active) {
            if($user===NULL){
                $this->errorCode = self::ERROR_USERNAME_INVALID; 
            }
            elseif (!$user->Active) {
                $this->errorCode = self::ERROR_USER_NOT_ACTIVE;
            }else{
                $this->errorCode = self::ERROR_USER_DELETED;}
        }else {
           
             
                if (!$user->validatePassword($this->password)) {
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                }
                else {
                    $this->_id = $user->uid;
                    $this->_username = $user->username;
                    if (NULL == $user->dateOfLastAccess) {
                        $lastLogin = time();
                    } else {
                        $lastLogin = strtotime($user->dateOfLastAccess);
                    }
                    
                    $this->setState('dateOfLastAccess', $lastLogin);
                    $this->errorCode = self::ERROR_NONE;
                    $user->dateOfLastAccess = date("Y-m-d H:i:s", time());
                   
                    $user->update(array('dateOfLastAccess')); //update the last login time
                    
                }
            
            

        }
        
		return !$this->errorCode;
	}
        
    
    /**
     * Return the current user id
     * @return type
     */
	public function getId() {
		return $this->_id;
	}
}
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	/*public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
}**/
