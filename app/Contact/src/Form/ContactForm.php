<?php

namespace Contact\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactForm extends Form
{
    /**
    * @var \Contact\Form\
    */    
    protected $captchaAdapter;
    
    /**
     * @var \Contact\Form\
     */        
    protected $csrfToken;

    /**
     * @param String     $name
     * @param           $captchaAdapter
     */    
    public function __construct($name = null, CaptchaAdapter $captchaAdapter = null)
    {
        parent::__construct($name);

        if (null !== $captchaAdapter) {
            $this->captchaAdapter = $captchaAdapter;
        }
        
        $name = $this->getName();
        
        if (null === $name) {
            $this->setName('contact');
        }

        // Add elements
        $this
            ->addFrom()
            ->addSubject()
            ->addBody()
            ->addSubmit()
            ->addCaptcha()
        ;
    }
    
    /**
     * Add the from form element.
     * 
     * @return \Contact\Form
     */
    protected function addFrom()
    {
        $this->add(array(
            'name' => 'from',
            'options' => array(
                'label' => 'From:',
            ),
            'attributes' => array(
                'type' => 'Zend\Form\Element\Text',
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
            'name' => 'subject',
            'options' => array(
                'label' => 'Subject:',
            ),
            'attributes' => array(
                'type' => 'Zend\Form\Element\Text',
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
            'name' => 'body',
            'options' => array(
                'label' => 'Your message:',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Textarea',
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',                
                'placeholder' => 'Your question',
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
            'attributes' => array(
                'type' => 'Zend\Form\Element\Submit',
                'value' => 'Send',
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }    
    
    /**
     * Add the Captcha
     * 
     * @return \Contact\Form
     */
    public function addCaptcha()
    {
        // Create Captcha element
        $captcha = new Element\Captcha('captcha');
        
        $captcha->setCaptcha($this->captchaAdapter);
        $captcha->setOptions(array('label' => 'Please verify you are human.'));
        
        // Add captcha
        $this->add($captcha);
        // Add csrf (Cross Site Request Forgery attack)
        $this->add(new Element\Csrf('csrf'));
    }
}
