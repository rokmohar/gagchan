<?php

namespace Core\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $__strictMode__ = false;
    
    /**
     * @var string
     */
    protected $fromEmail = 'no-reply@gagchan.com';
    
    /**
     * Return the email address.
     * 
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }
    
    /**
     * Set the email address.
     * 
     * @param string $fromEmail
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
        
        return $this;
    }
}