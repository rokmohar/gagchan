<?php

namespace Core\Mailer;

use Zend\View\Renderer\RendererInterface;

use Aws\Common\Aws;
use Core\Options\ModuleOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractAmazonMailer
{
    /**
     * @var \Aws\Common\Aws
     */
    protected $aws;
    
    /**
     * @var \Core\Options\ModuleOptions
     */
    protected $options;
    
    /**
     * @var \Zend\View\Renderer\RendererInterface
     */
    protected $renderer;
    
    /**
     * @param \Aws\Common\Aws                       $aws
     * @param \Core\Options\ModuleOptions           $options
     * @param \Zend\View\Renderer\RendererInterface $renderer
     */
    public function __construct(Aws $aws, ModuleOptions $options, RendererInterface $renderer)
    {
        $this->aws      = $aws;
        $this->options  = $options;
        $this->renderer = $renderer;
    }
    
    /**
     * Send a message.
     * 
     * @param string $fromEmail
     * @param string $toEmail
     * @param string $subject
     * @param string $body
     */
    public function sendMessage($fromEmail, $toEmail, $subject, $body)
    {
        var_dump($fromEmail, $toEmail, $subject, $body); die();
    }
    
    /**
     * Return the options.
     * 
     * @return \Core\Options\ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Get the rendered.
     * 
     * @return \Zend\View\Renderer\RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}
