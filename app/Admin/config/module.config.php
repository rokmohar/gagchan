<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'AdminIndex' => 'Admin\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller'  => 'AdminIndex',
                        'action'      => 'index',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/admin' => __DIR__ .  '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(__DIR__ . '/../view'),
    ),
);
