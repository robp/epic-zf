<?php
/**
 * Zend_Auth adapter for an extended Doctrine users record.
 * http://palo-verde.us/?blog/2009/08/16/zend_auth-adapter-with-doctrine.html
 * 
 * @package PaloVerde
 * @author Sam McCallum <sam@palo-verde.us>
 */
class User_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface {
    private $_username;
    private $_password;
    private $_userId;
    
    const NOT_FOUND_MESSAGE = "The username you entered could not be found.";
    const CREDENTIALS_MESSAGE = "The password you entered is not correct.";
    const STATUS_DISABLED_MESSAGE = "The user account is disabled.";
    const STATUS_CONFIRM_MESSAGE = "The user account is not confirmed.";
    const UNKNOWN_FAILURE = "Authentication failed for an unknown reason.";
    
    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }
    
    /** 
     * Zend_Auth hook.
     */
    public function authenticate() {
        try {
            $this->_userId = User_Model_User::authenticate($this->_username, $this->_password);
        } catch (Exception $e) {
            if ($e->getMessage() == User_Model_User::E_AUTH_NOT_FOUND) {
                return $this->notFound();
            }
            
            if ($e->getMessage() == User_Model_User::E_AUTH_PASSWORD_MISMATCH) {
                return $this->passwordMismatch();
            }
            
            if ($e->getMessage() == User_Model_User::E_AUTH_STATUS_DISABLED) {
                return $this->statusDisabled();
            }

            if ($e->getMessage() == User_Model_User::E_AUTH_STATUS_CONFIRM) {
                return $this->statusConfirm();
            }
            
            return $this->failed($e);
        }
        
        return $this->success();
    }
    
    /**
     * Factory for Zend_Auth_Result
     *
     *@param integer    The Result code, see Zend_Auth_Result
     *@param mixed      The Message, can be a string or array
     *@return Zend_Auth_Result
     */
    public function result($code, $messages = array()) {
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        
        return new Zend_Auth_Result(
            $code,
            $this->_userId,
            $messages
        );
    }
    
    /**
     * "User not found" wrapper for $this->result()
     */
    public function notFound() {
        return $this->result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, self::NOT_FOUND_MESSAGE);
    }
    
    /**
     * "Password does not match" wrapper for $this->result()
     */
    public function passwordMismatch() {
        return $this->result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, self::CREDENTIALS_MESSAGE);
    }

    /**
     * "Status is disabled" wrapper for $this->result()
     */
    public function statusDisabled() {
        return $this->result(Zend_Auth_Result::FAILURE, self::STATUS_DISABLED_MESSAGE);
    }
    
    /**
     * "Status is not confirmed" wrapper for $this->result()
     */
    public function statusConfirm() {
        return $this->result(Zend_Auth_Result::FAILURE, self::STATUS_CONFIRM_MESSAGE);
    }
    
    /**
     * General or Unknown failure wrapper for $this->result()
     */
    public function failed(Exception $e) {
        return $this->result(Zend_Auth_Result::FAILURE, self::UNKNOWN_FAILURE);
    }
    
    /**
     * "Success" wrapper for $this->result()
     */
    public function success() {
        return $this->result(Zend_Auth_Result::SUCCESS);
    }
    
    public function getResultRowObject()
    {
        return $this->_userId;
    }
}
