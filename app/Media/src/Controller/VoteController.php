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
        if (!$request->isXmlHttpRequest()) {
            // Redirect user to home
            return $this->redirect()->toRoute('home');
        }
        
        // Check if user is provided
        if (!$this->user()->hasIdentity()) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'not_logged_in',
            ));
        }
                
        // Check if page is not posted
        if (!$request->isPost()) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'not_post',
            ));
        }
        
        // Get form
        $form = $this->getVoteForm();
        
        // Bind entity
        $form->bind(new \Media\Entity\VoteEntity());

        // Set form data
        $form->setData($request->getPost());

        // Validate form
        if (!$form->isValid()) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'not_valid',
            ));
        }

        // Get form data
        $data = $form->getData();
        
        // Get media
        $media = $this->getMediaMapper()->selectRowBySlug(
            $form->get('slug')->getValue()
        );
        
        // Set media identifier
        $data->setMediaId($media->getId());
        
        // Get user
        $user = $this->user()->getIdentity();

        // Set user identifier
        $data->setUserId($user->getId());

        // Insert or update vote
        $this->getVoteMapper()->insertOrUpdate($data);
        
        // Count points
        $points = $this->getVoteMapper()->countByMedia($media);

        // Return JSON
        return new JsonModel(array(
            'result' => true,
            'points' => $points,
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
