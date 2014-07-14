<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Media\Index' => 'Media\Controller\IndexController',
            'Media\Vote'  => 'Media\Controller\VoteController',
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
            'vote' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/gag/vote',
                    'defaults' => array(
                        'controller' => 'Media\Vote',
                        'action'     => 'index',
                    ),
                ),
            ),
            'upload' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/upload',
                    'defaults' => array(
                        'controller' => 'Media\Index',
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