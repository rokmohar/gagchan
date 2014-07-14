<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteController extends AbstractActionController
{
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Mapper\VoteMapperInterface
     */
    protected $voteMapper;
    
    /**
     * @var \Media\Form\VoteForm
     */
    protected $voteForm;
    
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
        $form = $this->getVoteForm();

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

        // Insert or update vote
        $this->getVoteMapper()->insertOrUpdate(
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
     * @return \Media\Mapper\VoteMapperInterface
     */
    public function getVoteMapper()
    {
        if ($this->voteMapper === null) {
            // Load from service locator
            return $this->voteMapper = $this->getServiceLocator()->get(
                'media.mapper.vote'
            );
        }
        
        return $this->voteMapper;
    }
    
    /**
     * @return \Media\Form\VoteForm
     */
    public function getVoteForm()
    {
        if ($this->voteForm === null) {
            // Load from service locator
            return $this->voteForm = $this->getServiceLocator()->get(
                'media.form.vote'
            );
        }
        
        return $this->voteForm;
    }
}