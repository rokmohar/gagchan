<?php

namespace OAuth\Factory;

use Hybrid_Auth;

use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class HybridAuthFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        //$options = $serviceLocator->get('oauth.options.module');
        
        // Get hybrid auth
        $hybridAuth = new Hybrid_Auth(array(
            'base_url'  => $this->getBaseUrl($serviceLocator),
            'providers' => array(
                'facebook' => array(
                    'enabled' => true,
                    'keys'    => array(
                        'id'     => '786792028008106',
                        'secret' => '56ffa7c4bf4be09bc61b0cdc408bf685',
                    ),
                    'scope'          => 'public_profile email user_friends',
                    //'display'        => 'page',
                    //'trustForwarded' => false,
                ),
                'google'   => array(
                    'enabled' => true,
                    'keys'    => array(
                        'id'     => '93393983104-j9q4vgn3drbosrcenpr87fg6tn04uqte.apps.googleusercontent.com',
                        'secret' => '9-gljVIu75VIMWdvj44ZBlKZ',
                    ),
                    'scope' => 'profile email',
                    //'hd'    => '',
                ),
            ),
        ));
        
        return $hybridAuth;
    }

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * 
     * @return String
     * 
     * @throws ServiceNotCreatedException
     */
    public function getBaseUrl(ServiceLocatorInterface $serviceLocator)
    {
        $router = $serviceLocator->get('Router');
        
        if (!$router instanceof TreeRouteStack) {
            throw new ServiceNotCreatedException(
                'TreeRouteStack is required to create a fully qualified base url for HybridAuth'
            );
        }

        return $router->assemble(array(), array(
            'name'            => 'hybridauth',
            'force_canonical' => true,
        ));
    }
}