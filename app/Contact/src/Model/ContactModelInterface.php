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
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Return the subject.
     * 
     * @return string
     */
    public function getSubject();
    
    /**
     * Return the message.
     * 
     * @return string
     */
    public function getMessage();
}