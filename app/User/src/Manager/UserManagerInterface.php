<?php

namespace User\Manager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * Perform an authentication.
     * 
     * @param array $params
     * 
     * @return \Zend\Authentication\Result
     */
    public function authenticate(array $params);
    
    /**
     * Perform a logout.
     * 
     * @return mixed
     */
    public function logout(array $params);
    
    /**
     * Perform a recovery request.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function recoverRequest(array $data);
    
    /**
     * Perform a recovery reset.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function recoverReset(array $data);
    
    /**
     * Perform a registration.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function register(array $data);
    
    /**
     * Perform a sign up confirmation.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function registerConfirm(array $data);
    
    /**
     * Send a confirmation email message.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function sendConfirmationMessage(array $data);
    
    /**
     * Send a recover email message.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function sendRecoverMessage(array $data);
    
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService();
    
    /**
     * Return the confirmation mapper.
     * 
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * Return the mailer.
     * 
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer();
    
    /**
     * Return the user form.
     * 
     * @return \User\Form\UserForm
     */
    public function getSignupForm();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
}