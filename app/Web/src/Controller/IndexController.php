<?php

namespace Web\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * Access URI: /web/index/index
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
