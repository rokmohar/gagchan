<?php
namespace Cms;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }
    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
//               'core.options.module' => 'Core\Factory\Options\ModuleOptionsFactory',
            ),
        );
    }
}
