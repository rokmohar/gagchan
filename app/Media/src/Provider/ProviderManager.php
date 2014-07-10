<?php

namespace Media\Provider;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ProviderManager implements ProviderManagerInterface
{
    /**
     * @var Array
     */
    protected $providers = array();
    
    /**
     * {@inheritDoc}
     */
    public function addProvider($name, ProviderInterface $provider)
    {
        if ($this->hasProvider($name) === true) {
            throw new \InvalidArgumentException(
                sprintf('Provider with name "%s" already exists.', $name)
            );
        }
        
        $this->providers[$name] = $provider;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hasProvider($name)
    {
        return isset($this->providers[$name]);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getProvider($name)
    {
        if ($this->hasProvider($name) === false) {
            throw new \InvalidArgumentException(
                sprintf('Provider with name "%s" does not exist.', $name)
            );
        }
        
        return $this->providers[$name];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getProviders()
    {
        return $this->providers;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setProviders(array $providers)
    {
        $this->providers = $providers;
        
        return $this;
    }
}