<?php

namespace Media\Form;

use Category\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ExternalMediaForm extends AbstractMediaForm
{
    /**
     * @param string                                $name
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct($name, CategoryMapperInterface $categoryMapper)
    {
        parent::__construct($name, $categoryMapper);
        
        // Add elements
        $this
            ->addUrl()
            ->addDelayAt()
        ;
    }
    
    /**
     * Add the URL form element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addUrl()
    {
        $this->add(array(
            'name'    => 'url',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'URL',
            ),
        ));
        
        return $this;
    }
}
