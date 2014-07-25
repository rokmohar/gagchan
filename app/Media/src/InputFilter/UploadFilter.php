<?php

namespace Media\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadFilter extends MediaFilter
{
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        
        // Add filters
        $this
            ->addFile()
            ->addUrl()
        ;
    }
    
    /**
     * Add filter for the URL element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addFile()
    {
        $this->add(array(
            'name'       => 'file',
            'required'   => true,
            'validators' => array(
               array(
                    'name'    => 'Zend\Validator\File\Extension',
                    'options' => array(
                        'extension' => array(
                            'gif',
                            'jpeg',
                            'jpg',
                            'png',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\ImageSize',
                    'options' => array(
                        'minWidth'  => 80,
                        'minHeight' => 80,
                        'maxWidth'  => 2560,
                        'maxHeight' => 2560,
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\MimeType',
                    'options' => array(
                        'magicFile' => false,
                        'mimeType'  => array(
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\Size',
                    'options' => array(
                        'min' => '4kB',
                        'max' => '4MB',
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\File\UploadFile',
                ),
            ),
            'break_chain_on_failure' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the URL element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addUrl()
    {
        $this->add(array(
            'name'       => 'url',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Uri',
                ),
                array(
                    'name'    => 'Media\Validator\ValidatorChain',
                    'options' => array(
                        array(
                            'name'    => 'Zend\Validator\File\Extension',
                            'options' => array(
                                'extension' => array(
                                    'gif',
                                    'jpeg',
                                    'jpg',
                                    'png',
                                ),
                            ),
                        ),
                        array(
                            'name'    => 'Zend\Validator\File\ImageSize',
                            'options' => array(
                                'minWidth'  => 80,
                                'minHeight' => 80,
                                'maxWidth'  => 2560,
                                'maxHeight' => 2560,
                            ),
                        ),
                        array(
                            'name'    => 'Zend\Validator\File\MimeType',
                            'options' => array(
                                'magicFile' => false,
                                'mimeType'  => array(
                                    'image/gif',
                                    'image/jpeg',
                                    'image/png',
                                ),
                            ),
                        ),
                        array(
                            'name'    => 'Zend\Validator\File\Size',
                            'options' => array(
                                'min' => '4kB',
                                'max' => '4MB',
                            ),
                        ),
                    ),
                    'break_chain_on_failure' => true,
                ),
            ),
            'filters'   => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
}