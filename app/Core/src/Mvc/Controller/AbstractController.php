<?php
namespace Core\Mvc\Controller;
use Zend\Mvc\Controller\AbstractActionController;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class AbstractController extends AbstractActionController
{
    /**
     * @return Object|array
     */
    public function get($name)
    {
        return $this->getServiceLocator()->get($name);
    }
}