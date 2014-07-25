<?php

namespace Core\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractFilter extends InputFilter
{
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }
    
    /**
     * Return the option.
     * 
     * @param string $name
     * 
     * @return mixed
     */
    public function getOption($name)
    {
        return ($this->hasOption($name) ? $this->options[$name] : null);
    }
    
    /**
     * Return options.
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Check whether the option exists.
     * 
     * @param string $name
     * 
     * @return bool
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }
    
    /**
     * Set options.
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        
        return $this;
    }
}