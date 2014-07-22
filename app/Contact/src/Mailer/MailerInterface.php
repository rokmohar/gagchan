<?php

namespace Contact\Mailer;

use Contact\Model\ContactModelInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send a contact email message.
     * 
     * @param \Contact\Model\ContactModelInterface $contact
     */
    public function sendContactMessage(ContactModelInterface $contact);
}