<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Category\Index' => 'Category\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/category/[:slug]',
                    'defaults' => array(
                        'controller'  => 'Category\Index',
                        'action'      => 'index',
                        'constraints' => array(
                            'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../view',
        ),
    ),
);