<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Generator\IndexController' => 'Generator\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/generator',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'index/index'     => __DIR__ . '/../view/contact/index/index.phtml',
        ),
        'template_path_stack' => array(
            'generator' => __DIR__ . '/../view',
        ),
    ),
);