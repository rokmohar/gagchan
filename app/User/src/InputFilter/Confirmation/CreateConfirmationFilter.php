<?php

namespace User\InputFilter\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CreateConfirmationFilter extends AbstractConfirmationFilter
{
    /**
     * {@inheritDoc}
     */
    protected function buildFilter()
    {
        $this
            ->addUserId()
            ->addEmail()
            ->addRemoteAddress()
            ->addRequestAt()
            ->addRequestToken()
            ->addConfirmedAt()
            ->addCreatedAt()
            ->addUpdatedAt()
        ;
    }
}