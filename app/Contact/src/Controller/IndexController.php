<?php
namespace Contact\Controller;
use Zend\Http\Response;
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
    public function contactAction()
    {
        // Get PRG
        $prg = $this->prg();
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        // Get form
        $contactForm = $this->getContactForm();
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'form' => $contactForm,
            ));
        }
        // Bind model
        $contactForm->bind(new \Contact\Model\ContactModel());
        // Set data
        $contactForm->setData($prg);
        // Check if form is not valid
        if (!$contactForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'form' => $contactForm,
            ));
        }
        // Get data
        $contact = $contactForm->getData();
        // Set remote address
        $contact->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );
        // Get mailer
        $mailer = $this->getMailer();
        // Send message
        $mailer->sendContactMessage($contact);
        // Create view
        $view = new ViewModel(array(
            'contact' => $contact,
        ));
        // Set template
        $view->setTemplate('contact/index/contact_success');
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
