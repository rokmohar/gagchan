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
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/contact',
                    'defaults' => array(
                        'controller' => 'Contact\IndexController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'index/index'     => __DIR__ . '/../view/contact/index/index.phtml',
            'index/thank-you' => __DIR__ . '/../view/contact/index/thank-you.phtml',
        ),
        'template_path_stack' => array(
            'contact' => __DIR__ . '/../view',
        ),
    ),
);