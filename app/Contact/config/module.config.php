<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Contact\IndexController' => 'Contact\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        'controller' => 'Contact\IndexController',
                        'action'     => 'contact',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'contact' => __DIR__ . '/../view',
        ),
    ),
);