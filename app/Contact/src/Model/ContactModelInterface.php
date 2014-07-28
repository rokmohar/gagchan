<?php

namespace Contact\Model;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ContactModelInterface
{
    /**
     * Return the remote address.
     * 
     * @return string
     */
    public function getRemoteAddress();
    
    /**
     * Set the remote address.
     * 
     * @param string $remoteAddress
     */
    public function setRemoteAddress($remoteAddress);
    
    /**
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Set the email address.
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Return the subject.
     * 
     * @return string
     */
    public function getSubject();
    
    /**
     * Set the subject.
     * 
     * @param string $subject
     */
    public function setSubject($subject);
    
    /**
     * Return the message.
     * 
     * @return string
     */
    public function getMessage();
    
    /**
     * Set the message.
     * 
     * @param string $message
     */
    public function setMessage($message);
}