<?php

namespace Contact\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var Boolean
     */
    protected $__strictMode__ = false;
    
    /**
     * @var array
     */
    protected $transport = array(
        'class'   => 'Zend\Mail\Transport\Sendmail',
        'options' => array(),
    );
    
    /**
     * @var array
     */
    protected $message = array();
    
    /**
     * @return array
     */
    public function getTransport()
    {
        return $this->transport;
    }
    
    /**
     * @param array $transport
     */
    public function setTransport(array $transport)
    {
        $this->transport = $transport;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * @param array $message
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
        
        return $this;
    }
}