<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'IndexController' => 'Media\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'gag' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    'route' => '/gag/[:slug]',
                    'defaults' => array(
                        'controller'  => 'IndexController',
                        'action'      => 'details',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                        'defaults' => array(),
                    ),
                ),
            ),
            'media' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/media',
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