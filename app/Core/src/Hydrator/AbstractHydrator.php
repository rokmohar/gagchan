<?php

namespace Core\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractHydrator extends ClassMethods
{
    /**
     * @var array
     */
    protected $dataMap = array();
    
    /**
     * @var array
     */
    private $strategyMap = array(
        'bool'     => '\Core\Hydrator\Strategy\BooleanStrategy',
        'boolean'  => '\Core\Hydrator\Strategy\BooleanStrategy',
        'DateTime' => '\Core\Hydrator\Strategy\DateTimeStrategy',
        'int'      => '\Core\Hydrator\Strategy\IntegerStrategy',
        'integer'  => '\Core\Hydrator\Strategy\IntegerStrategy',
        'string'   => '\Core\Hydrator\Strategy\StringStrategy',
    );
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        foreach ($this->dataMap as $data => $type) {
            // Add strategy for data type
            if (isset($this->strategyMap[$type])) {
                // Get class
                $class = $this->strategyMap[$type];
                
                // Add strategy
                $this->addStrategy($data, new $class);
            }
            else {
                // Invalid argument type
                throw new \RuntimeException(sprintf(
                    "Hydrator for data type \"%s\" does not exist",
                    $type
                ));
            }
        }
    }
}