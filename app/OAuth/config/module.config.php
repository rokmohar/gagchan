<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'OAuth\Index' => 'OAuth\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            // Connect
            'connect' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/connect/[:provider]',
                    'defaults' => array(
                        'controller' => 'OAuth\Index',
                        'action'      => 'connect',
                        'constraints' => array(
                            'provider' => '[a-zA-Z]*',
                        ),
                    ),
                ),
            ),
            // HybridAuth
            'hybridauth' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/hybridauth',
                    'defaults' => array(
                        'controller' => 'OAuth\Index',
                        'action'      => 'hybridAuth',
                    ),
                ),
            ),
            // Log in
            'oauth' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/login/[:provider]',
                    'defaults' => array(
                        'controller' => 'OAuth\Index',
                        'action'      => 'login',
                        'constraints' => array(
                            'provider' => '[a-zA-Z]*',
                        ),
                    ),
                ),
            ),
        ),
    ),
);