<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'IndexController' => 'Media\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/category/[:slug]',
                    'defaults' => array(
                        'controller'  => 'IndexController',
                        'action'      => 'index',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../view',
        ),
    ),
);