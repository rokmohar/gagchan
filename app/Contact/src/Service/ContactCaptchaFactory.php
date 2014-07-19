<?php

namespace Contact\Service;

use Traversable;
use Zend\Captcha\Factory as CaptchaFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactCaptchaFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('config');
        
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        $spec = $config['contact']['captcha'];
        $captcha = CaptchaFactory::factory($spec);
        
        // Return Captcha
        return $captcha;
    }
}