<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\IndexController' => 'User\Controller\IndexController',
            'User\UserController'  => 'User\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'User\IndexController',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'User\IndexController',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'signup' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/signup',
                    'defaults' => array(
                        'controller' => 'User\IndexController',
                        'action'     => 'signup',
                    ),
                ),
            ),
            'signup' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'User\UserController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'change_password' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/change-password',
                            'defaults' => array(
                                'controller' => 'User\UserController',
                                'action'     => 'changePassword',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'scn-social-auth' => __DIR__ . '/../view',
            'user'            => __DIR__ . '/../view',
        ),
    ),
);