<?php

namespace Contact\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactFormEntity implements ContactFormEntityInterface 
{
    /**
     * @var String
    */
    protected $form;    
    
    /**
     * Get contact form
     * 
     * @return String
     */
    public function getContactForm()
    {
        return $this->form;
    }
    
    /**
    * Set contact form
    * 
    * @param String $form
    */    
    public function setContactForm(ContactForm $form)
    {
        $this->form = $form;
        
        return $this;
    }
}