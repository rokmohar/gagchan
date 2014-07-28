<?php

namespace Contact\Mailer;

use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplateMapResolver;

Use Contact\Model\ContactModelInterface;
use Core\Mailer\AbstractAmazonMailer;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AmazonMailer extends AbstractAmazonMailer implements MailerInterface
{
    /**
     * @var \Zend\View\Resolver\ResolverInterface
     */
    protected $resolver;
    
    /**
     * {@inheritDoc}
     */
    public function sendContactMessage(ContactModelInterface $contact)
    {
        // Get renderer
        $renderer = $this->getRenderer();
        
        // Set resolver
        $renderer->setResolver($this->getResolver());
        
        // Get view
        $view = new ViewModel(array(
            'host'    => $contact->getRemoteAddress(),
            'email'   => $contact->getEmail(),
            'subject' => $contact->getSubject(),
            'message' => $contact->getMessage(),
        ));
        
        // Set HTML template
        $view->setTemplate('index/contact.html');
        
        // Render HTML template
        $htmlBody = $renderer->render($view);
        
        // Set text template
        $view->setTemplate('index/contact.text');
        
        // Render text template
        $textBody = $renderer->render($view);
        
        // Send a message
        $result = $this->sendMessage(
            $this->getOptions()->getFromEmail(),
            'info@gagchan.com',
            sprintf('[Contact] %s', $contact->getSubject()),
            $textBody,
            $htmlBody
        );
        
        // Return result
        return $result;
    }
    
    /**
     * Return the resolver.
     * 
     * @return \Zend\View\Resolver\ResolverInterface
     */
    public function getResolver()
    {
        if ($this->resolver === null) {
            return $this->resolver = new TemplateMapResolver(array(
                'index/contact.html' => __DIR__ . '/../../view/email/index/contact_html.phtml',
                'index/contact.text' => __DIR__ . '/../../view/email/index/contact_text.phtml',
            ));
        }
        
        return $this->resolver;
    }
}
