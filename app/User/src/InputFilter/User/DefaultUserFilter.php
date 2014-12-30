<?php

namespace User\InputFilter\User;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DefaultUserFilter extends AbstractUserFilter
{
    /**
     * {@inheritDoc}
     */
    protected function buildFilter()
    {
        $this
            ->addCsrf()
            ->addUsername()
            ->addEmail()
            ->addPassword()
            ->addPasswordVerify()
            ->addState()
            ->addCreatedAt()
            ->addUpdatedAt()
        ;
    }
}