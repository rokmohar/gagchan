<?php
namespace Category\Factory\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Media\Form\CategoryForm;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get category mapper
        $categoryMapper = $serviceLocator->get('category.mapper.category');
        // Create form
        $form = new CategoryForm($categoryMapper);
        // Get hydrator
        $hydrator = new \Category\Hydrator\CategoryHydrator();
        // Set hydrator
        $form->setHydrator($hydrator);
        // Get input filter
        $inputFilter = new \Category\InputFilter\CategoryFilter($categoryMapper);
        // Set input filter
        $form->setInputFilter($inputFilter);
        // Return form
        return $form;
    }
}