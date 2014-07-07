<?php

namespace Web\Controller;

use Zend\View\Model\ViewModel;

use Core\Mvc\Controller\AbstractController;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class IndexController extends AbstractController
{
    /**
     * @var \Zend\Http\Request
     */
    protected $request;
    
    /**
     * Access URI: /web/index/index
     */
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * @return \Zend\Http\Request
     */
    public function getRequest()
    {
        if ($this->request === null) {
            return $this->request = $this->get('request');
        }
        
        return $this->request;
    }
}
