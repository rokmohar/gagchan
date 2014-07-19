<?php

namespace Contact\Controller;

use Contact\Form\ContactForm;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactController extends AbstractActionController
{
    
    /**
     * @var \Contact\Form\
     */    
    protected $form;
    
    /**
     * @var \Contact\Form\
     */    
    protected $message;
    
    /**
     * @var \Contact\Form\
     */    
    protected $transport;
    
    /**
    * Set message
    * 
    * @param String $message
    */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        
        return $this;
    }
    
    /**
     * Set mail transport
     * 
     * @param String $transport
     */    
    public function setMailTransport(Transport\TransportInterface $transport)
    {
        $this->transport = $transport;
        
        return $this;
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

    /**
     * @return array 
     */
    public function indexAction()
    {
        return array(
            'form' => $this->form,
        );
    }

    /**
     * @return \Zend\View\Model\ViewModel    
     */
    public function processAction()
    {        
        // Get request
        $request = $this->getRequest();
        
        // Check if form is posted
        if ($request->isPost() === false) {
            return $this->redirect()->toRoute('contact');
        }
                
        // Set the form
        $form = $this->form;
        
        // Set form data
        $form->setData($request->getPost());
        
        // Check if form is valid
        if ($form->isValid() === false) {
            // Set view model
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));
            $model->setTemplate('contact/index');
            
            // Return new view model
            return $model;
        }

        // Send emial
        $this->sendEmail($form->getData());

        // Redirect to thank-you page
        return $this->redirect()->toRoute('contact/thank-you');
    }

    /**
     * Thank you action after email send
     * 
     * @return array
     */
    public function thankYouAction()
    {
        // Get headers
        $headers = $this->request->getHeaders();
        
        // Check if 
        if ($headers->has('Referer') === false
            || preg_match('#/contact$#', $headers->get('Referer')->getFieldValue() === false)
        ) {
            return $this->redirect()->toRoute('contact');
        }

        // Return array
        return array();
    }

    /**
     * Send email
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
    }
}