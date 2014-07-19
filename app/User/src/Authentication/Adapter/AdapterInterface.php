<?php

namespace User\Authentication\Adapter;

use User\Authentication\Event\AuthenticationEvent;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Perform an authentication.
     * 
     * @param \User\Authentication\Event\AuthenticationEvent $event
     */
    public function authenticate(AuthenticationEvent $event);
}