<?php

namespace Contact\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class MessageEntity implements MessageEntityInterface 
{
    /**
     * @var String
    */
    protected $message;
    
    /**
     * @var String
    */
    protected $transport;
    
    /**
    * {@inheritDoc}
    */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
    * Set message
    * 
    * @param String $message
    */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        
        return $this;
    }

    /**
    * {@inheritDoc}
    */
    public function getMailTransport()
    {
        return $this->transport;
    }    
    
    /**
     * Set mail transport
     * 
     * @param String $transport
     */    
    public function setMailTransport(Transport\TransportInterface $transport)
    {
        $this->transport = $transport;
        
        return $this;
    }
}
