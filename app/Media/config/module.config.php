<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Media\Index'   => 'Media\Controller\IndexController',
            'Media\Upload'  => 'Media\Controller\UploadController',
            'Media\Vote'    => 'Media\Controller\VoteController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Media\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'gag' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/gag/[:slug]',
                    'defaults' => array(
                        'controller' => 'Media\Index',
                        'action'      => 'details',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
            ),
            'upload' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/upload',
                    'defaults' => array(
                        'controller' => 'Media\Upload',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'external' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/external',
                            'defaults' => array(
                                'controller' => 'Media\Upload',
                                'action'     => 'external',
                            ),
                        ),
                    ),
                ),
            ),
            'vote' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/vote',
                    'defaults' => array(
                        'controller' => 'Media\Vote',
                        'action'     => 'index',
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