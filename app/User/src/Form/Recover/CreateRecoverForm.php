<?php

namespace User\Form\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CreateRecoverForm extends AbstractRecoverForm
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
            ->addRecoveredAt()
            ->addIsRecovered()
            ->addCreatedAt()
            ->addUpdatedAt()
        ;
    }
}