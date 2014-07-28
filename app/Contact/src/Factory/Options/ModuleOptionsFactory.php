<?php
namespace Contact\Factory\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Contact\Options\ModuleOptions;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Config
        $config = $serviceLocator->get('Config');
        // Module config
        $moduleConfig = isset($config['contact']) ? $config['contact'] : array();
        // Return mapper
        return new ModuleOptions($moduleConfig);
    }
}