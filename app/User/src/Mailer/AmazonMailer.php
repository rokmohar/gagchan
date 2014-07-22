<?php

namespace User\Mailer;

use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplateMapResolver;

use Core\Mailer\AbstractAmazonMailer;
use User\Entity\ConfirmationEntityInterface;
use User\Entity\RecoverEntityInterface;
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
    public function sendConfirmationMessage(
        UserEntityInterface $user,
        ConfirmationEntityInterface $confirmation
    ) {
        // Get renderer
        $renderer = $this->getRenderer();
        
        // Set resolver
        $renderer->setResolver($this->getResolver());
        
        // Get view
        $view = new ViewModel(array(
            'user' => $user,
            'url'  => $this->getRouter()->assemble(array(
                'id'    => $confirmation->getId(),
                'token' => $confirmation->getRequestToken(),
            ), array(
                'name'            => 'signup/confirm',
                'force_canonical' => true,
            )),
            'host' => $confirmation->getRemoteAddress(),
        ));
        
        // Set HTML template
        $view->setTemplate('signup/confirmation_html');
        
        // Render HTML template
        $htmlBody = $renderer->render($view);
        
        // Set text template
        $view->setTemplate('signup/confirmation_text');
        
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
    public function sendRecoverMessage(
        UserEntityInterface $user,
        RecoverEntityInterface $recover
    ) {
        // Get renderer
        $renderer = $this->getRenderer();
        
        // Set resolver
        $renderer->setResolver($this->getResolver());
        
        // Get view
        $view = new ViewModel(array(
            'user' => $user,
            'url'  => $this->getRouter()->assemble(array(
                'id'    => $recover->getId(),
                'token' => $recover->getRequestToken(),
            ), array(
                'name'            => 'recover/reset',
                'force_canonical' => true,
            )),
            'host' => $recover->getRemoteAddress(),
        ));
        
        // Set HTML template
        $view->setTemplate('recover/request_html');
        
        // Render HTML template
        $htmlBody = $renderer->render($view);
        
        // Set text template
        $view->setTemplate('recover/request_text');
        
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
                'recover/request_html'     => __DIR__ . '/../../view/email/recover/request_html.phtml',
                'recover/request_text'     => __DIR__ . '/../../view/email/recover/request_text.phtml',
                'signup/confirmation_html' => __DIR__ . '/../../view/email/signup/confirmation_html.phtml',
                'signup/confirmation_text' => __DIR__ . '/../../view/email/signup/confirmation_text.phtml',
            ));
        }
        
        return $this->resolver;
    }
}
