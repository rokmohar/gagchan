<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'MediaController' => 'Media\Controller\MediaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'media' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/media',
                    'defaults' => array(
                        'controller' => 'MediaController',
                        'action'     => 'upload',
                    ),
                ),
                /*'may_terminate' => true,
                'child_routes' => array(
                    'upload' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/upload',
                            'defaults' => array(
                                'controller' => 'MediaController',
                                'action'     => 'upload',
                            ),
                        ),
                    ),
                ),*/
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'media' => __DIR__ . '/../view',
        ),
    ),
);