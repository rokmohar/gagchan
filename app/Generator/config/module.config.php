<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Generator\IndexController' => 'Generator\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'generator' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/generator',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action' => 'index',
                    ),
                ),
            ),
            'edit' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/edit/[:slug]',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action'      => 'edit',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
            ), 
            'prototype' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/upload-prototype',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action' => 'prototype',
                    ),
                ),
            ),   
            'preview' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/preview',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action'     => 'preview',
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
            'generator' => __DIR__ . '/../view',
        ),
    ),
);