<?php

namespace Contact\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
interface MessageEntityInterface 
{
    /**
    * Retrun message
    * 
    * @return String
    */
    public function getMessage();

    /**
     * Return the mail transport.
     * 
     * @return String
     */
    public function getMailTransport();
}