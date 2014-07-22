<?php

namespace Contact\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Contact\Form\ContactForm
     */    
    protected $contactForm;
    
    /**
     * @var \Contact\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @return array 
     */
    public function indexAction()
    {
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $contactForm = $this->getContactForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'form' => $contactForm,
            ));
        }
        
        // Bind model
        $contactForm->bind(new \Contact\Model\ContactModel());
        
        // Set data
        $contactForm->setData($request->getPost());
        
        // Check if form is not valid
        if ($contactForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'form' => $contactForm,
            ));
        }
        
        // Get data
        $data = $contactForm->getData();
        
        // Set remote address
        $data->setRemoteAddress($request->getServer('REMOTE_ADDR'));
        
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send message
        $mailer->sendContactMessage($data);
        
        // Create view
        $view = new ViewModel();
        
        // Set template
        $view->setTemplate('index/thank-you');
        
        // Return view
        return $view;
    }
    
    /**
     * Return the contact form.
     * 
     * @return \Contact\Form\ContactForm
     */
    public function getContactForm()
    {
        if ($this->contactForm === null) {
            return $this->contactForm = $this->getServiceLocator()->get(
                'contact.form.contact'
            );
        }
        
        return $this->contactForm;
    }
    
    /**
     * Return the mailer.
     * 
     * @return \Contact\Mailer\MailerInterface
     */
    public function getMailer()
    {
        if ($this->mailer === null) {
            return $this->mailer = $this->getServiceLocator()->get(
                'contact.mailer.amazon'
            );
        }
        
        return $this->mailer;
    }
    
    /**
     * Return the message.
     * 
     * @return \Zend\Mail\Message
     */
    public function getMessage()
    {
        if ($this->message === null) {
            return $this->message = $this->getServiceLocator()->get(
                'contact.mail.message'
            );
        }
        
        return $this->message;
    }
    
    /**
     * Return the transport.
     * 
     * @return \Zend\Mail\Transport
     */
    public function getTransport()
    {
        if ($this->transport === null) {
            return $this->transport = $this->getServiceLocator()->get(
                'contact.mail.transport'
            );
        }
        
        return $this->transport;
    }
}