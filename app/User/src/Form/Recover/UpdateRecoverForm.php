<?php

namespace User\Form\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UpdateRecoverForm extends AbstractRecoverForm
{
    /**
     * {@inheritDoc}
     */
    protected function buildForm()
    {
        $this
            ->addRecoveredAt()
            ->addIsRecovered()
            ->addUpdatedAt()
        ;
    }
}