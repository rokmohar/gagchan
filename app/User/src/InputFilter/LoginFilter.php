<?php

namespace User\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LoginFilter extends UserFilter
{
    /**
     * Add the email address input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addEmail()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\EmailAddress',
                ),
                array(
                    'name'    => 'Zend\Validator\stringLength',
                    'options' => array(
                        'max' => 255,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\stringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
}