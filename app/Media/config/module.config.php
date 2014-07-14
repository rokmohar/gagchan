<?php

return array(
    'controllers' => array(
        'invokables' => array(
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
            'gag' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/gag',
                    'defaults' => array(),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'details' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/[:slug]',
                            'defaults' => array(
                                'controller' => 'IndexController',
                                'action'      => 'details',
                                'constraints' => array(
                                    'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                                ),
                            ),
                        ),
                    ),
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