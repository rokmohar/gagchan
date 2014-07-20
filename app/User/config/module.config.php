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
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'choose' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/[:id]/[:token]',
                            'defaults' => array(
                                'controller'  => 'User\RecoverController',
                                'action'      => 'choose',
                                'constraints' => array(
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
                        'action'     => 'index',
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
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'scn-social-auth' => __DIR__ . '/../view',
            'user'            => __DIR__ . '/../view',
        ),
    ),
);