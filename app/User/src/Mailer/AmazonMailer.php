<?php

namespace User\Mailer;

use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplateMapResolver;

use Core\Mailer\AbstractAmazonMailer;
use User\Entity\UserEntityInterface;

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
    public function sendConfirmationMessage(UserEntityInterface $user)
    {
        // Get renderer
        $renderer = $this->getRenderer();
        
        // Set resolver
        $renderer->setResolver($this->getResolver());
        
        // Get view
        $view = new ViewModel(array(
            'user' => $user,
            'url'  => '{@todo: insert URL}',
            'host' => '{@todo: insert host}',
        ));
        
        // Set HTML template
        $view->setTemplate('signup/confirmation.html');
        
        // Render HTML template
        $htmlBody = $renderer->render($view);
        
        // Set text template
        $view->setTemplate('signup/confirmation.text');
        
        // Render text template
        $textBody = $renderer->render($view);
        
        // Send a message
        $result = $this->sendMessage(
            $this->getOptions()->getFromEmail(),
            $user->getEmail(),
            'Registration confirmation',
            $textBody,
            $htmlBody
        );
        
        // Return result
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function sendRecoverMessage(UserEntityInterface $user)
    {
        // Get renderer
        $renderer = $this->getRenderer();
        
        // Set resolver
        $renderer->setResolver($this->getResolver());
        
        // Get view
        $view = new ViewModel(array(
            'user' => $user,
            'url'  => '{@todo: insert URL}',
            'host' => '{@todo: insert host}',
        ));
        
        // Set HTML template
        $view->setTemplate('recover/request.html');
        
        // Render HTML template
        $htmlBody = $renderer->render($view);
        
        // Set text template
        $view->setTemplate('recover/request.text');
        
        // Render text template
        $textBody = $renderer->render($view);
        
        // Send a message
        $result = $this->sendMessage(
            $this->getOptions()->getFromEmail(),
            $user->getEmail(),
            'Password recovery',
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
                'recover/request.html'     => __DIR__ . '/../../view/email/recover/request_html.phtml',
                'recover/request.text'     => __DIR__ . '/../../view/email/recover/request_text.phtml',
                'signup/confirmation.html' => __DIR__ . '/../../view/email/signup/confirmation_html.phtml',
                'signup/confirmation.text' => __DIR__ . '/../../view/email/signup/confirmation_text.phtml',
            ));
        }
        
        return $this->resolver;
    }
}
