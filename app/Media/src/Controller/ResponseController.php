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
     * @var \Media\Mapper\ResponseMapperInterface
     */
    protected $responseMapper;
    
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
        
        // Check if request is not JSON
        if ($request->isXmlHttpRequest() === false) {
            // Redirect user to home
            return $this->redirect()->toRoute('home');
        }
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'notPost',
            ));
        }
        // Get form
        $form = $this->getResponseForm();

        // Set form data
        $form->setData($request->getPost());

        // Validate form
        if ($form->isValid() === false) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'notValid',
                'post' => $form->getData(),
            ));
        }

        // Get form data
        $slug = $form->get('slug')->getValue();
        $type = $form->get('type')->getValue();

        // Get user data
        $user = $this->zfcUserAuthentication()->getIdentity();

        // Check if user is provided
        if (empty($user) === true) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'notLoggedIn',
            ));
        }
        
        // Get media
        $media = $this->getMediaMapper()->selectOneBySlug($slug);

        // Insert or update response
        $this->getResponseMapper()->insertOrUpdate(
            $media->getId(),
            $user->getId(),
            $type
        );

        // Return JSON
        return new JsonModel(array(
            'result' => true,
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
     * @return \Media\Mapper\ResponseMapperInterface
     */
    public function getResponseMapper()
    {
        if ($this->responseMapper === null) {
            // Load from service locator
            return $this->responseMapper = $this->getServiceLocator()->get(
                'media.mapper.response'
            );
        }
        
        return $this->responseMapper;
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
