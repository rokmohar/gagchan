<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\Recover\CreateRecoverForm;
use User\Hydrator\RecoverHydrator;
use User\InputFilter\Recover\CreateRecoverFilter;

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
        $form = new CreateRecoverForm($recoverMapper, $userMapper);
        
        // Create hydrator
        $hydrator = new RecoverHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Create input filter
        $inputFilter = new CreateRecoverFilter($recoverMapper, $userMapper);
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}