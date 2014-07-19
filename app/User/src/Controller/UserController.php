<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserController extends AbstractActionController
{
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        // Check if user does not have identity
        if ($this->user()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function changePasswordAction()
    {
        // Check if user does not have identity
        if ($this->user()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Return view
        return new ViewModel(array());
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            return $this->userMapper = $this->getServiceLocator()->get(
                'user.mapper.user'
            );
        }
        
        return $this->userMapper;
    }
}