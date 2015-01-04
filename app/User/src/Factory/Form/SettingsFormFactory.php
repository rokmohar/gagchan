<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\DefaultUserForm;
use User\Hydrator\UserHydrator;
use User\InputFilter\DefaultUserFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class SettingsFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new DefaultUserForm($userMapper);
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'email',
            'username',
            'updated_at',
        ));
        
        // Create hydrator
        $form->setHydrator(new UserHydrator());
        
        // Create input filter
        $inputFilter = new DefaultUserFilter($userMapper);
        
        // Enable validators
        $inputFilter
            ->enableEmailUniqueRecord()
            ->enableUsernameUniqueRecord()
        ;
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}