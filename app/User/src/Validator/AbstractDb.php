<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractDb extends AbstractValidator
{
    /**
     * @param string
     */
    protected $field;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $mapper;
    
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['field'])) {
            throw new \InvalidArgumentException("Option \"field\" is required.");
        }
        
        if (!isset($options['mapper'])) {
            throw new \InvalidArgumentException("Option \"mapper\" is required");
        }
        
        $this->field  = $options['field'];
        $this->mapper = $options['mapper'];
        
        unset($options['field']);
        unset($options['mapper']);
        
        parent::__construct($options);
    }
}