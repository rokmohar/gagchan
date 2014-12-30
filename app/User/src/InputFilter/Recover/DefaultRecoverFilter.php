<?php

namespace User\InputFilter\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DefaultRecoverFilter extends AbstractRecoverFilter
{
    /**
     * {@inheritDoc}
     */
    protected function buildFilter()
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
        ;
    }
}