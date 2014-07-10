<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        // Media name
        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Alnum',
                    'options' => array(
                        'allowWhiteSpace' => true,
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
        // Upload media
        $this->add(array(
            'name'     => 'file',
            'required' => false,
        ));
        
        // Media URL
        $this->add(array(
            'name'       => 'url',
            'required'   => false,
            /*'validators' => array(
                array(
                    'name' => 'Hostname',
                ),
            ),*/
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
    }
}