<?php

namespace User\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LoginFilter extends UserFilter
{
    /**
     * Add the username input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addUsername()
    {
        $this->add(array(
            'name'       => 'username',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Regex',
                    'options' => array(
                        'pattern'  => '/^[a-zA-Z\d\.\_]*$/',
                        'messages' => array(
                            \Zend\Validator\Regex::NOT_MATCH => 'Value can only contain letters, numbers, dot and underscore.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 6,
                        'max' => 255,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
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
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        //'min' => 6,
                        'max' => 255,
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\EmailAddress',
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
}