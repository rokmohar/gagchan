<?php

namespace User\Mailer;

use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send a confirmation email message.
     * 
     * @param \User\Entity\UserEntityInterface $user
     */
    public function sendConfirmationMessage(UserEntityInterface $user);
    
    /**
     * Send a recover email message.
     * 
     * @param \User\Entity\UserEntityInterface $user
     */
    public function sendRecoverMessage(UserEntityInterface $user);
}