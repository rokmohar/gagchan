<?php

namespace Layout\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\View\Http\ViewManager;
use Zend\Stdlib\Parameters;

use Layout\Options\LayoutOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LayoutService implements
    ListenerAggregateInterface
{
    /**
     * @trait \Zend\EventManager\EventManagerAwareTrait
     */
    use EventManagerAwareTrait;
    
    /**
     * @var \Layout\Options\LayoutOptions
     */
    protected $options;
    
    /**
     * @var \Zend\Stdlib\Parameters
     */
    protected $params;
    
    /**
     * @var \Zend\Mvc\View\Http\ViewManager
     */
    protected $viewManager;
    
    /**
     * @param array
     * @param \Layout\Options\LayoutOptions
     * @param \Zend\Mvc\View\Http\ViewManager
     */
    public function __construct(array $config, LayoutOptions $options, ViewManager $viewManager)
    {
        $this->config      = $config;
        $this->options     = $options;
        $this->viewManager = $viewManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            array($this, 'onRoute'),
            -2000
        );
    }
    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                // Remove listener
                unset($this->listeners[$index]);
            }
        }
    }
    
    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onRoute(MvcEvent $e)
    {
        // Get route match
        $routeMatch = $e->getRouteMatch();
        
        // Get controller
        $controller = $routeMatch->getParam('controller');

        // Get configuration
        $config      = $this->getConfig();
        $controllers = isset($config['controllers']['invokables']) ?
            $config['controllers']['invokables'] : array();
        
        // Get module
        $module = isset($controllers[$controller]) ? $controllers[$controller] : '';
        $module = substr($module, 0, strpos($module, '\\'));
        
        // Set params
        $this
            ->setParam('module', $module)
            ->setParam('controller', $controller)
            ->setParam('action', $routeMatch->getParam('action'))
            ->setParam('route', $routeMatch->getMatchedRouteName())
        ;
        
        // Select layout
        $this->selectLayout();
    }
    
    /**
     * @param $layouts
     * @param $key
     */
    protected function applyLayout($layouts, $key)
    {
        // Return false, iff the requested layout was not found
        if (false === $layout = $this->loadLayout($layouts, $key)) {
            return false;
        }
        
        // Get view model
        $view = $this->getViewManager()->getViewModel();
        $view->setTemplate($layout);
        
        return true;
    }
    
    /**
     * @param $layouts
     * @param $key
     */
    protected function loadLayout($layouts, $key = null)
    {
        // Return false, iff layouts are not provided
        if (!$layouts) {
            return false;
        }

        // Return layout, iff the requested key exists
        return isset($layouts[$key]) ? $layouts[$key] : false;
    }
    
    /**
     * Select a layout, based on module options.
     */
    protected function selectLayout()
    {
        // Get options
        $options = $this->getOptions();

        // Try to apply route rule based layout
        if ($options->getEnableRouteLayouts()) {
            // Get route layouts
            $routeLayouts = $options->getRouteLayouts();
            
            // Get route param
            $route = $this->getParam('route');
            
            if ($this->applyLayout($routeLayouts, $route)) {
                return;
            }
        }

        // Try to apply mca rule based layout
        if ($options->getEnableMcaLayouts()) {
            // Get MCA layouts
            $mcaLayouts = $options->getMcaLayouts();
            
            // Get MCA params
            $module     = $this->getParam('module');
            $controller = $this->getParam('controller');
            $action     = $this->getParam('action');
            
            if ($this->applyLayout($mcaLayouts, $module . '\\' . $controller . '\\' . $action)) {
                return;
            }

            if ($this->applyLayout($mcaLayouts, $module . '\\' . $controller)) {
                return;
            }

            if ($this->applyLayout($mcaLayouts, $module)) {
                return;
            }
        }
    }
    
    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * @return \Layout\Options\LayoutOptions
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * @return \Zend\Stdlib\Parameters
     */
    public function getParams()
    {
        if (!$this->params) {
            // Create parameters
            $this->params = new Parameters();
        }
        
        return $this->params;
    }
    
    /**
     * @param $name
     * @param $default
     * 
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        return $this->getParams()->get($name, $default);
    }
    
    /**
     * @param $name
     * @param $value
     */
    public function setParam($name, $value)
    {
        $this->getParams()->set($name, $value);
        
        return $this;
    }

    /**
     * @return \Zend\Mvc\View\Http\ViewManager
     */
    public function getViewManager()
    {
        return $this->viewManager;
    }
}

