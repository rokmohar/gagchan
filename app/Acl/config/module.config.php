<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Acl\IndexController'    => 'Acl\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/acl',
                    'defaults' => array(
                        'controller' => 'Acl\IndexController',
                        'action'     => 'acl',
                    ),
                ),
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'acl' => __DIR__ . '/../view',
        ),
    ),
);