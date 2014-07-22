<?php

namespace User\Mailer;

use User\Entity\ConfirmationEntityInterface;
use User\Entity\RecoverEntityInterface;
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
     * @param \User\Entity\UserEntityInterface         $user
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function sendConfirmationMessage(
        UserEntityInterface $user,
        ConfirmationEntityInterface $confirmation
    );
    
    /**
     * Send a recover email message.
     * 
     * @param \User\Entity\UserEntityInterface    $user
     * @param \User\Entity\RecoverEntityInterface $recover
     */
    /**
     * {@inheritDoc}
     */
    public function sendRecoverMessage(
        UserEntityInterface $user,
        RecoverEntityInterface $recover
    );
}