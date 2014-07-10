<?php

namespace Media\Provider;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface ProviderManagerInterface
{
    /**
     * Add new provider to the collection.
     * 
     * @param String                             $name
     * @param \Media\Provider\ProviderInterface $provider
     */
    public function addProvider($name, ProviderInterface $provider);
    
    /**
     * Check if collection contains a provider.
     * 
     * @param String $name
     */
    public function hasProvider($name);
    
    /**
     * Return provider by name.
     * 
     * @param String $name
     */
    public function getProvider($name);
    
    /**
     * Return collection of providers.
     * 
     * @return Array
     */
    public function getProviders();
    
    /**
     * Set collection of providers.
     * 
     * @param Array $providers
     */
    public function setProviders(array $providers);
}