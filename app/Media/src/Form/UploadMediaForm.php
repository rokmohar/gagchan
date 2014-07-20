<?php

namespace Media\Form;

use Category\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadMediaForm extends AbstractMediaForm
{
    /**
     * @param string                                $name
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct($name, CategoryMapperInterface $categoryMapper)
    {
        parent::__construct($name, $categoryMapper);
        
        // Set enctype
        $this->setAttribute('enctype', 'multipart/form-data');
        
        // Add elements
        $this
            ->addFile()
        ;
    }
    
    /**
     * Add media file input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addFile()
    {
        $this->add(array(
            'name'    => 'file',
            'options' => array(
                'label' => 'Upload',
            ),
            'attributes' => array(
                'type'        => 'file',
                'class'       => 'form-control',
                'placeholder' => 'Upload',
            ),
        ));
        
        return $this;
    }
}
