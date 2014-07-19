<?php

return array(
    'contact' => array(
        'captcha' => array(
            'class' => 'dumb',
        ),
        'form' => array(
            'name' => 'contact',
        ),
        'mail_transport' => array(
            'class' => 'Zend\Mail\Transport\Sendmail',
            'options' => array(
            )
        ),
        'message' => array(
                        /*
            'to' => array(
            'EMAIL HERE' => 'NAME HERE',
            ),
            'sender' => array(
            'address' => 'EMAIL HERE',
            'name' => 'NAME HERE',
            ),
            'from' => array(
            'EMAIL HERE' => 'NAME HERE',
            ),
            */
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Controller\Contact' => 'Contact\Service\ContactControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/contact',
                    'defaults' => array(
                        'controller' => 'Controller\Contact',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/process',
                            'defaults' => array(
                                'action' => 'process',
                            ),
                        ),
                    ),
                    'thank-you' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/thank-you',
                            'defaults' => array(
                                'action' => 'thank-you',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ContactCaptcha' => 'Contact\Service\ContactCaptchaFactory',
            'ContactForm' => 'Contact\Service\ContactFormFactory',
            'ContactMailMessage' => 'Contact\Service\ContactMailMessageFactory',
            'ContactMailTransport' => 'Contact\Service\ContactMailTransportFactory',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'contact/index' => __DIR__ . '/../view/contact/contact/index.phtml',
            'contact/thank-you' => __DIR__ . '/../view/contact/contact/thank-you.phtml',
        ),
        'template_path_stack' => array(
            'contact' => __DIR__ . '/../view',
        ),
    ),
);