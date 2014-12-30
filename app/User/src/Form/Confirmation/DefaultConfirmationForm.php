<?php

namespace User\Form\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DefaultConfirmationForm extends AbstractConfirmationForm
{
    /**
     * {@inheritDoc}
     */
    protected function buildForm()
    {
        $this
            ->addUserId()
            ->addEmail()
            ->addRemoteAddress()
            ->addRequestAt()
            ->addRequestToken()
            ->addConfirmedAt()
            ->addIsConfirmed()
            ->addCreatedAt()
            ->addUpdatedAt()
        ;
    }
}