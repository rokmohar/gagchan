<?php

namespace Media\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ExternalMediaFilter extends AbstractMediaFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();
        
        // Add filters
        $this
            ->addUrl()
            ->addDelayAt()
        ;
    }
    
    /**
     * Add for the URL form element.
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
                    'options' => array(
                        'allow_relative' => false,
                        'allow_absolute' => true,
                    ),
                    'break_chain_on_failure' => true,
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
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
        
        return $this;
    }
}