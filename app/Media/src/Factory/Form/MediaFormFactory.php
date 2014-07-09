<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\MediaForm;
use Media\InputFilter\MediaFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new MediaForm('media');
        $form->setInputFilter(new MediaFilter());

        return $form;
    }
}