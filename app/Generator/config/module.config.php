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
                    'route'    => '/edit/[:image]',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action'      => 'edit',
                        'constraints' => array(
                            'image' => '[a-zA-Z][a-zA-Z0-9]*',
                        ),
                    ),
                ),
            ),            
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'generator' => __DIR__ . '/../view',
        ),
    ),
);