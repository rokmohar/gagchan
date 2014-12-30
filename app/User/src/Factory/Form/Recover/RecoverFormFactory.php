<?php

namespace User\Factory\Form\Recover;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\Recover\DefaultRecoverForm;
use User\Hydrator\RecoverHydrator;
use User\InputFilter\Recover\DefaultRecoverFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get recover mapper
        $recoverMapper = $serviceLocator->get('user.mapper.recover');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new DefaultRecoverForm($recoverMapper, $userMapper);
        
        // Create hydrator
        $form->setHydrator(new RecoverHydrator());
        
        // Create input filter
        $form->setInputFilter(new DefaultRecoverFilter($recoverMapper, $userMapper));
        
        // Return form
        return $form;
    }
}