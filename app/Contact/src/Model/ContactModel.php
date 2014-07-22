<?php

namespace Contact\Model;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ContactModel implements ContactModelInterface
{
    /**
     * @var string
     */
    protected $remoteAddress;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $subject;
    
    /**
     * @var string
     */
    protected $message;
    
    /**
     * {@inheritDoc}
     */
    public function getRemoteAddress()
    {
        return $this->remoteAddress;
    }
    
    /**
     * Set the remote address.
     * 
     * @param string $remoteAddress
     */
    public function setRemoteAddress($remoteAddress)
    {
        $this->remoteAddress = $remoteAddress;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set the email address.
     * 
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Set the subject.
     * 
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Set the message.
     * 
     * @return string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        
        return $this;
    }
}