<?php

namespace Media\Form;

use Category\Mapper\CategoryMapperInterface;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadForm extends MediaForm
{
    /**
     * @param \Media\Mapper\MediaMapperInterface    $mediaMapper
     * @param \User\Mapper\UserMapperInterface      $userMapper
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        UserMapperInterface $userMapper,
        CategoryMapperInterface $categoryMapper
    ) {
        parent::__construct($mediaMapper, $userMapper, $categoryMapper);
        
        // Add elements
        $this
            ->addFile()
            ->addUrl()
        ;
    }
    
    /**
     * Add the file element.
     * 
     * @return \Media\Form\UploadForm
     */
    protected function addFile()
    {
        $this->add(array(
            'name'    => 'file',
            'type'    => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Select file ...',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Select file ...',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the URL element.
     * 
     * @return \Media\Form\UploadForm
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
    
    /**
     * Enable file upload.
     * 
     * @return \Media\Form\UploadForm
     */
    public function enableFileUpload()
    {
        $this->setAttribute('enctype', 'multipart/form-data');
        
        return $this;
    }
}
