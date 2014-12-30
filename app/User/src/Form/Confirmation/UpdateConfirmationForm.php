<?php

namespace User\Form\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CreateConfirmationForm extends AbstractConfirmationForm
{
    /**
     * {@inheritDoc}
     */
    protected function buildForm()
    {
        $this
            ->addConfirmedAt()
            ->addIsConfirmed()
            ->addUpdatedAt()
        ;
    }
}