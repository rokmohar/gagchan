<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;

use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractDb extends AbstractValidator
{
    /**#@+*/
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';
    /**#@-*/
    
    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => "No record matching the input was found",
        self::ERROR_RECORD_FOUND    => "A record matching the input was found",
    );
    
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
            throw new \InvalidArgumentException(
                "Field is required, nothing given."
            );
        }
        
        if (!isset($options['mapper']) || !$options['mapper'] instanceof UserMapperInterface) {
            throw new \InvalidArgumentException(
                "Mapper is required and must be instance of User\Mapper\UserMapperInterface."
            );
        }
        
        $this->field  = $options['field'];
        $this->mapper = $options['mapper'];
        
        unset($options['field']);
        unset($options['mapper']);
        
        parent::__construct($options);
    }
}