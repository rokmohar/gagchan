<?php

namespace Contact\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactForm extends Form
{
    /**
     * @param String $name
     * @param array  $options
     */    
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);

        // Add elements
        $this
            ->addCsrf()
            ->addFrom()
            ->addSubject()
            ->addBody()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the CSRF form element.
     * 
     * @return \User\Form\AbstractForm
     */
    public function addCsrf()
    {
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        return $this;
    }
    
    /**
     * Add the email address form element.
     * 
     * @return \Contact\Form
     */
    protected function addFrom()
    {
        $this->add(array(
            'name'    => 'from',
            'options' => array(
                'label' => 'From',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Text',
                'class'       => 'form-control',
                'placeholder' => 'Your email',
            ),
        ));
        
        return $this;
    }    
    
    /**
     * Add the subject form element.
     * 
     * @return \Contact\Form
     */
    protected function addSubject()
    {
        $this->add(array(
            'name'    => 'subject',
            'options' => array(
                'label' => 'Subject',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Text',
                'class'       => 'form-control',
                'placeholder' => 'Subject',
            ),            
        ));
        
        return $this;
    }    
    
    /**
     * Add the subject form element.
     * 
     * @return \Contact\Form
     */
    protected function addBody()
    {
        $this->add(array(
            'name'    => 'body',
            'options' => array(
                'label' => 'Your message',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Textarea',
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',                
                'placeholder' => 'Your message',
            ),            
        ));
        
        return $this;
    }   
    
    /**
     * Add the submit form element.
     * 
     * @return \Contact\Form
     */
    public function addSubmit()
    {
        $this->add(array(
            'name' => 'Send',
            'options' => array(
                'label' => 'Send',
            ),
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Submit',
                'class' => 'btn btn-primary',
                'value' => 'Send',
            ),
        ));
        
        return $this;
    }    
}
