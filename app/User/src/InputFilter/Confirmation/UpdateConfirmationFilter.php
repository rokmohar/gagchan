<?php

namespace User\InputFilter\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UpdateConfirmationFilter extends AbstractConfirmationFilter
{
    /**
     * {@inheritDoc}
     */
    protected function buildFilter()
    {
        $this
            ->addConfirmedAt()
            ->addIsConfirmed()
            ->addUpdatedAt()
        ;
    }
}