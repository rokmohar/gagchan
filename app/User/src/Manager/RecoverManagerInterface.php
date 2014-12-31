<?php

namespace User\Manager;

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
     * @param array $data
     */
    public function createRecover(array $data);
    
    /**
     * Update recovery.
     * 
     * @param \User\Entity\RecoverEntityInterface $recover
     * @param array                               $data
     */
    public function updateRecover(RecoverEntityInterface $recover, array $data);
    
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
     * @return \User\Form\Recover\RecoverFormInterface
     */
    public function getRecoverForm();
    
    /**
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}