<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        // Add form elements
        $this
            ->addComment()
        ;
    }
    
    /**
     * Add filter for comment.
     */
    protected function addComment()
    {
        $this->add(array(
            'name'       => 'comment',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'HtmlEntities'),
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
    }
}