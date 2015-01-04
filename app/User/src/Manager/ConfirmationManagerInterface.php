<?php

namespace User\Manager;

use Zend\Stdlib\RequestInterface;

use User\Entity\ConfirmationEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationManagerInterface
{
    /**
     * Create account confirmation.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param \Zend\Stdlib\RequestInterface    $request
     */
    public function createConfirmation(UserEntityInterface $user, RequestInterface $request);
    
    /**
     * Complete account confirmation.
     * 
     * @param \User\Entity\UserEntityInterface         $user
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function processConfirmation(UserEntityInterface $user, ConfirmationEntityInterface $confirmation);
    
    /**
     * Send confirmation message.
     * 
     * @param \User\Entity\UserEntityInterface         $user
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function sendConfirmationMessage(UserEntityInterface $user, ConfirmationEntityInterface $confirmation);
    
    /**
     * Generate random token.
     * 
     * @return string
     */
    public function generateToken();
    
    /**
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapper
     */
    public function getUserMapper();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}