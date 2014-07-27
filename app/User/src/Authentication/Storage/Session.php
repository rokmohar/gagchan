<?php

namespace User\Authentication\Storage;

use Zend\Authentication\Storage\Session as ZendSession;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Session extends ZendSession implements StorageInterface
{
    /**
     * {@inheritDoc}
     */
    public function rememberMe($ttl)
    {
        $this->session->getManager()->rememberMe($ttl);
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
        
        return $this;
    }
}