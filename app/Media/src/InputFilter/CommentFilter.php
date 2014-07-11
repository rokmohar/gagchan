<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class CommentFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
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
                array('name' => 'StringTrim'),
            ),
        ));
    }
}