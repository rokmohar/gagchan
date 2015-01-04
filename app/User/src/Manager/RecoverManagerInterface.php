<?php

namespace User\Manager;

use Zend\Stdlib\RequestInterface;

use User\Entity\RecoverEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverManagerInterface
{
    /**
     * Create recovery.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param \Zend\Stdlib\RequestInterface    $request
     */
    public function createRecover(UserEntityInterface $user, RequestInterface $request);
    
    /**
     * Complete account recovery.
     * 
     * @param \User\Entity\UserEntityInterface    $user
     * @param \User\Entity\RecoverEntityInterface $recover
     */
    public function processRecover(UserEntityInterface $user, RecoverEntityInterface $recover);
    
    /**
     * Send recovery message.
     * 
     * @param \User\Entity\UserEntityInterface    $user
     * @param \User\Entity\RecoverEntityInterface $recover
     */
    public function sendRecoverMessage(UserEntityInterface $user, RecoverEntityInterface $recover);
    
    /**
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer();
    
    /**
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper();
    
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