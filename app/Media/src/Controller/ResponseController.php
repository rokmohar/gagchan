<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ResponseController extends AbstractActionController
{
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Form\ResponseForm
     */
    protected $responseForm;
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function indexAction()
    {
        // Get request
        $request = $this->getRequest();
        
        // Check if page is posted
        if ($request->isPost() === true) {
            // Get form
            $form = $this->getResponseForm();

            // Set form data
            $form->setData($request->getPost());
            
            // Check if form is valid
            if ($form->isValid() === true) {
                // Return JSON
                return new JsonModel(array(
                    'result' => true,
                ));
            }
        }
        
        // Return JSON
        return new JsonModel(array(
            'result' => false,
        ));
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        if ($this->mediaMapper === null) {
            // Load from service locator
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
    
    /**
     * @return \Media\Form\ResponseForm
     */
    public function getResponseForm()
    {
        if ($this->responseForm === null) {
            // Load from service locator
            return $this->responseForm = $this->getServiceLocator()->get(
                'media.form.response'
            );
        }
        
        return $this->responseForm;
    }
}
