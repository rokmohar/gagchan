<?php

namespace User\Authentication\Storage;

use Zend\Authentication\Storage\StorageInterface as ZendStorageInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface StorageInterface extends ZendStorageInterface
{
    /**
     * Remember this session.
     * 
     * @param int $ttl
     */
    public function rememberMe($ttl);
    
    /**
     * Forget this session.
     */
    public function forgetMe();
}