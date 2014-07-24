<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\IndexController'    => 'User\Controller\IndexController',
            'User\RecoverController'  => 'User\Controller\RecoverController',
            'User\SettingsController' => 'User\Controller\SettingsController',
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
            'recover' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/recover',
                    'defaults' => array(
                        'controller' => 'User\RecoverController',
                        'action'     => 'request',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'reset' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/[:id]/[:token]',
                            'defaults' => array(
                                'controller'  => 'User\RecoverController',
                                'action'      => 'reset',
                                'constraints' => array(
                                    'id'    => '[0-9]*',
                                    'token' => '[a-zA-Z0-9]*',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'settings' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/settings',
                    'defaults' => array(
                        'controller' => 'User\SettingsController',
                        'action'     => 'account',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'password' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/password',
                            'defaults' => array(
                                'controller' => 'User\SettingsController',
                                'action'     => 'password',
                            ),
                        ),
                    ),
                    'social' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/social',
                            'defaults' => array(
                                'controller' => 'User\SettingsController',
                                'action'     => 'social',
                            ),
                        ),
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
                'may_terminate' => true,
                'child_routes'  => array(
                    'confirm' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/confirm/[:id]/[:token]',
                            'defaults' => array(
                                'controller'  => 'User\IndexController',
                                'action'      => 'confirm',
                                'constraints' => array(
                                    'id'    => '[0-9]*',
                                    'token' => '[a-zA-Z0-9]*',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),
);