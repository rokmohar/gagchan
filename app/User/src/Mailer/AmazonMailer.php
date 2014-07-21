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
        
        // Set template
        $view->setTemplate('recover/request');
        
        // Render template
        $output = $renderer->render($view);
        
        var_dump($output); die();
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
                'recover/request' => __DIR__ . '/../../view/email/recover/request.phtml',
            ));
        }
        
        return $this->resolver;
    }
}
