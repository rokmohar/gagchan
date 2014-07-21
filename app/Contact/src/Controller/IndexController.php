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
     * @var \Zend\Mail\Message
     */    
    protected $message;
    
    /**
     * @var \Zend\Mail\Transport
     */    
    protected $transport;
    
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
        
        // Set data
        $contactForm->setData($request->getPost());
        
        // Check if form is not valid
        if ($contactForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'error' => true,
                'form' => $contactForm,
            ));
        }
        
        // Send email
        $this->sendEmail($contactForm->getData());
        
        // Create view
        $view = new ViewModel();
        
        // Set template
        $view->setTemplate('index/thank-you');
        
        // Return view
        return $view;
    }

    /**
     * Send the email message.
     * 
     * @param array $data
     */
    protected function sendEmail(array $data)
    {
        $from    = $data['from'];
        $subject = '[Contact Form] ' . $data['subject'];
        $body    = $data['body'];

        // Add data to mail
        $mail = $this->message
            ->addFrom($from)
            ->addReplyTo($from)
            ->addTo('tugamer@gmail.com', 'Rok Z.')
            ->setSubject($subject)
            ->setBody($body)
        ;
        
        // Send email
        $this->transport->send($mail);
        
        return $this;
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