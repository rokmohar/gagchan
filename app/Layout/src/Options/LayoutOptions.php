<?php

namespace Layout\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LayoutOptions extends AbstractOptions
{
    /**
     * @var Boolean
     */
    protected $__strictMode__ = false;
    
    /**
     * @var array
     */
    protected $options = array();
    
    /**
     * @var array
     */
    protected $mcaLayouts = array();
    
    /**
     * @var array
     */
    protected $routeLayouts = array();
    
    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * @param $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        
        return $this;
    }
    
    /**
     * @return Boolean
     */
    public function getMcaLayouts()
    {
        return $this->mcaLayouts;
    }
    
    /**
     * @param $mcaLayouts
     */
    public function setMcaLayouts(array $mcaLayouts)
    {
        $this->mcaLayouts = $mcaLayouts;
        
        return $this;
    }
    
    /**
     * @return Boolean
     */
    public function getRouteLayouts()
    {
        return $this->routeLayouts;
    }
    
    /**
     * @param $routeLayouts
     */
    public function setRouteLayouts(array $routeLayouts)
    {
        $this->routeLayouts = $routeLayouts;
        
        return $this;
    }
    
    /**
     * @return Boolean
     */
    public function getEnableMcaLayouts()
    {
        // Get options
        $options = $this->getOptions();
        
        return isset($options['enable_mca_layouts']) ?
            $options['enable_mca_layouts'] : false;
    }
    
    /**
     * @return Boolean
     */
    public function getEnableRouteLayouts()
    {
        // Get options
        $options = $this->getOptions();
        
        return isset($options['enable_route_layouts']) ?
            $options['enable_route_layouts'] : false;
    }
}