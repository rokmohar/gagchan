<?php

namespace User\Manager;

use User\Entity\ConfirmationEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationManagerInterface
{
    /**
     * Create confirmation.
     * 
     * @param array $data
     */
    public function createConfirmation(array $data);
    
    /**
     * Update confirmation.
     * 
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     * @param array                                    $data
     */
    public function updateConfirmation(ConfirmationEntityInterface $confirmation, array $data);
    
    /**
     * Send confirmation message.
     * 
     * @param \User\Entity\UserEntityInterface         $user
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function sendConfirmationMessage(UserEntityInterface $user, ConfirmationEntityInterface $confirmation);
    
    /**
     * @return \User\Form\Confirmation\ConfirmationFormInterface
     */
    public function getConfirmationForm();
    
    /**
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}