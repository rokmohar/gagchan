<?php
namespace Contact\Factory\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Contact\Form\ContactForm;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ContactFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Create form
        $form = new ContactForm();
        // Get hydrator
        $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
        // Set hydrator
        $form->setHydrator($hydrator);
        // Get input filter
        $inputFilter = new \Contact\InputFilter\ContactFilter();
        // Set input filter
        $form->setInputFilter($inputFilter);
        // Return form
        return $form;
    }
}