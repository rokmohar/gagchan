<?php

namespace User\Form\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DefaultRecoverForm extends AbstractRecoverForm
{
    /**
     * {@inheritDoc}
     */
    protected function buildForm()
    {
        $this
            ->addCsrf()
            ->addUserId()
            ->addEmail()
            ->addRemoteAddress()
            ->addRequestAt()
            ->addRecoveredAt()
            ->addIsRecovered()
            ->addCreatedAt()
            ->addUpdatedAt()
            ->addSubmit()
        ;
    }
}