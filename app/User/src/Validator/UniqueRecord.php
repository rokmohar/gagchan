<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;

use User\Entity\UserEntityInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UniqueRecord extends AbstractDb
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
                "Option \"field\" is required, nothing given."
            );
        }
        
        if (!isset($options['mapper']) || !$options['mapper'] instanceof UserMapperInterface) {
            throw new \InvalidArgumentException(
                "Option \"mapper\" must be an instance of User\Mapper\UserMapperInterface."
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
        // Find match
        $match = $this->mapper->selectRow(array(
            $this->field => $value,
        ));
        
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
            throw new \InvalidArgumentException("Identifier is required, nothing given.");
        }
        
        return array(
            'id' => $context['id'],
        );
    }
    
    /**
     * Return found identifiers.
     * 
     * @return array
     */
    protected function getFoundIdentifiers(UserEntityInterface $match)
    {
        return array(
            'id' => $match->getId(),
        );
    }
}