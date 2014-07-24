<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;

use User\Entity\UserEntityInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UniqueRecord extends AbstractValidator
{
    /**#@+*/
    const ERROR_RECORD_FOUND = 'recordFound';
    /**#@-*/
    
    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::ERROR_RECORD_FOUND => "A record matching the input was found",
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
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        // Get where
        $where = array();
        
        $where[$this->field] = $value;
        
        // Find match
        $match = $this->mapper->selectRow($where);
        
        // Check if match is empty
        if (empty($match)) {
            // No record found
            return true;
        }
        
        // Get identifiers
        $expectedIdentifiers = $this->getExpectedIdentifiers($context);
        $foundIdentifiers    = $this->getFoundIdentifiers($match);

        // Compare identifiers
        if (count(array_diff_assoc($expectedIdentifiers, $foundIdentifiers)) === 0) {
            // No record found
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_RECORD_FOUND);
        
        // Record found
        return false;
    }
    
    /**
     * Return expected identifiers.
     * 
     * @return array
     */
    protected function getExpectedIdentifiers(array $context)
    {
        if (!array_key_exists('id', $context)) {
            throw new \InvalidArgumentException(
                "Identifier is required, nothing given."
            );
        }
        
        $result = array(
            'id' => $context['id'],
        );
        
        return $result;
    }
    
    /**
     * Return found identifiers.
     * 
     * @return array
     */
    protected function getFoundIdentifiers(UserEntityInterface $match)
    {
        $result = array(
            'id' => $match->getId(),
        );
        
        return $result;
    }
}