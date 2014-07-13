<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'CategoryController' => 'Media\Controller\CategoryController',
            'IndexController'    => 'Media\Controller\IndexController',
            'ResponseController' => 'Media\Controller\ResponseController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'index',
                    ),
                ),
            ),
            'category' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/category/[:slug]',
                    'defaults' => array(
                        'controller'  => 'CategoryController',
                        'action'      => 'index',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                    ),
                ),
            ),
            'gag' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/gag/[:slug]',
                    'defaults' => array(
                        'controller'  => 'IndexController',
                        'action'      => 'details',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'response' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/response',
                            'defaults' => array(
                                'controller' => 'ResponseController',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            'upload' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/upload',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'upload',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'json' => 'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            'media' => __DIR__ . '/../view',
        ),
    ),
);