<?php

namespace Cms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function privacyAction()
    {
        return new ViewModel();
    }
  
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function termsAction()
    {
        return new ViewModel();
    }    
}