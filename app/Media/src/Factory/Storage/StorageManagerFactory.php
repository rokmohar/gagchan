<?php

namespace Media\Factory\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Storage\StorageManager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class StorageManagerFactory implements FactoryInterface
{
    /**
     * @var Array
     */
    protected $storages = array(
        'amazon' => 'Media\Storage\AmazonStorage',
    );
    
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Create service
        $storageManager = new StorageManager($serviceLocator);
        
        // Attach storages to storage manager
        foreach ($this->storages as $name => $class) {
            // Create storage
            $storage = new $class($serviceLocator);
            
            // Add storage
            $storageManager->addStorage($name, $storage);
        }
        
        // Return storage manager
        return $storageManager;
    }
}