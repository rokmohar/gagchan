<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DefaultUserForm extends AbstractUserForm
{
    /**
     * {@inheritDoc}
     */
    protected function buildForm()
    {
        $this
            ->addCsrf()
            ->addId()
            ->addUsername()
            ->addEmail()
            ->addPassword()
            ->addPasswordVerify()
            ->addState()
            ->addCreatedAt()
            ->addUpdatedAt()
            ->addCaptcha()
            ->addSubmit()
        ;
    }
}