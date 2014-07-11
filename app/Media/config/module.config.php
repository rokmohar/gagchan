<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'CategoryController' => 'Media\Controller\CategoryController',
            'IndexController'    => 'Media\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'category' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/category/[:id]',
                    'defaults' => array(
                        'controller'  => 'CategoryController',
                        'action'      => 'index',
                        'constraints' => array(
                            'id' => '[0-9]*',
                        ),
                    ),
                ),
            ),
            'gag' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gag/[:slug]',
                    'defaults' => array(
                        'controller'  => 'IndexController',
                        'action'      => 'details',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
            ),
            'upload' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/upload',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'upload',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'media' => __DIR__ . '/../view',
        ),
    ),
);