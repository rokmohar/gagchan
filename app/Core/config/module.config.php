<?php

return array(
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    ),
    'view_manager' => array(
        'display_exceptions'       => true,
        'display_not_found_reason' => true,
        'doctype'                  => 'HTML5',
        'exception_template'       => 'error/index',
        'layout'                   => 'layout/frontend',
        'not_found_template'       => 'error/404',
        'template_map' => array(),
        'template_path_stack' => array(
            'core' => __DIR__ . '/../view',
        ),
    ),
);