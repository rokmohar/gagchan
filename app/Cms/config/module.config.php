<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Cms\IndexController' => 'Cms\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'privacy' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/privacy-policy',
                    'defaults' => array(
                        'controller' => 'Cms\IndexController',
                        'action' => 'privacy',
                    ),
                ),
            ),
            'terms' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/terms-of-use',
                    'defaults' => array(
                        'controller' => 'Cms\IndexController',
                        'action' => 'terms',
                    ),
                ),
            ),            
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'index/privacy'     => __DIR__ . '/../view/cms/index/privacy.phtml',
            'index/terms'     => __DIR__ . '/../view/cms/index/terms.phtml',
        ),
        'template_path_stack' => array(
            'cms' => __DIR__ . '/../view',
        ),
    ),
);