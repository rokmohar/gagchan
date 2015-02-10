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
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/generator',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'edit' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/[:slug]',
                            'defaults' => array(
                                'controller' => 'Generator\IndexController',
                                'action'      => 'edit',
                                'constraints' => array(
                                    'slug' => '[a-zA-Z][a-zA-Z\-]*',
                                ),
                            ),
                        ),
                    ),
                    'publish' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/publish',
                            'defaults' => array(
                                'controller'  => 'Generator\IndexController',
                                'action'      => 'publish',
                            ),
                        ),
                    ),
                ),
            ),
            'save' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/save',
                    'defaults' => array(
                        'controller' => 'Generator\IndexController',
                        'action'     => 'save',
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