<?php

namespace Contact\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ContactForm extends Form
{
    /**
     * @param string $name
     * @param array  $options
     */    
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);

        // Add elements
        $this
            ->addCsrf()
            ->addEmail()
            ->addSubject()
            ->addMessage()
            ->addCaptcha()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the CSRF element.
     * 
     * @return \Contact\Form\ContactForm
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
     * Add the email address element.
     * 
     * @return \Contact\Form\ContactForm
     */
    protected function addEmail()
    {
        $this->add(array(
            'name'    => 'email',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Your email address',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Your email address',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the subject element.
     * 
     * @return \Contact\Form\ContactForm
     */
    protected function addSubject()
    {
        $this->add(array(
            'name'    => 'subject',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Subject',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Subject',
            ),            
        ));
        
        return $this;
    }
    
    /**
     * Add the message element.
     * 
     * @return \Contact\Form\ContactForm
     */
    protected function addMessage()
    {
        $this->add(array(
            'name'    => 'message',
            'type'    => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Your message',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',                
                'placeholder' => 'Your message',
            ),            
        ));
        
        return $this;
    }
    
    /**
     * Add captcha element.
     * 
     * @return \User\Form\AbstractUserForm
     */
    public function addCaptcha()
    {
        $this->add(array(
            'name'    => 'captcha',
            'type'    => 'Zend\Form\Element\Captcha',
            'options' => array(
                'label'   => 'Please type the following text',
                'captcha' => array(
                    'class'   => 'Zend\Captcha\ReCaptcha',
                    'options' => array(
                        'pubkey'  => '6LdWDvcSAAAAAFjb7VFZFR47NMZYQL7t2saq28ua',
                        'privkey' => '6LdWDvcSAAAAAAjhm56hU22-FmpXI1LXGveN0yo_',
                        'theme'   => 'white',
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add submit element.
     * 
     * @return \Contact\Form\ContactForm
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
