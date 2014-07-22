<?php

namespace Media\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\File\UploadedImage;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @var \Media\Form\CommentForm
     */
    protected $commentForm;
    
    /**
     * @var \Media\Mapper\CommentMapperInterface
     */
    protected $commentMapper;
    
    /**
     * @var \Media\Form\ExternalMediaForm
     */
    protected $externalMediaForm;
    
    /**
     * @var \Media\Form\UploadMediaForm
     */
    protected $uploadMediaForm;
    
    /**
     * @var \Media\Service\MediaManagerInterface
     */
    protected $mediaManager;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function indexAction()
    {
        // Get params from query
        $page = (int) $this->params()->fromQuery('page', 1);
        
        // Select from database
        $media = $this->getMediaMapper()->selectLatest();
        $media->setCurrentPageNumber($page);
        
        // Set items per page
        $media->setItemCountPerPage(20);
        
        // Retun view
        return new ViewModel(array(
            'media' => $media,
        ));
    }
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function detailsAction()
    {
        // Select media
        $media = $this->getMediaMapper()->selectRowBySlug(
            $this->params()->fromRoute('slug')
        );
        
        // Check if match is empty
        if (empty($media)) {
            // Media not found
            return $this->notFoundAction();
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get comment form
        $commentForm = $this->getCommentForm();
        
        // Get comments
        $comments = $this->getCommentMapper()->selectByMedia($media);
        
        // Check if PRG is GET
        if ($prg === false) {
            
            // Return view
            return new ViewModel(array(
                'media'       => $media,
                'commentForm' => $commentForm,
                'comments'    => $comments,
            ));
        }

        // Bind entity
        $commentForm->bind(new \Media\Entity\CommentEntity());

        // Set data
        $commentForm->setData($prg);

        // Check if form is not valid
        if (!$commentForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'media'       => $media,
                'commentForm' => $commentForm,
                'comments'    => $comments,
            ));
        }
        
        // Get data
        $data = $commentForm->getData();

        // Set required data
        $data->setMediaId($media->getId());
        $data->setUserId($this->user()->getIdentity()->getId());

        // Insert comment
        $this->getCommentMapper()->insertRow($data);

        // Redirect to route
        return $this->redirect()->toRoute('gag', array(
            'slug' => $media->getSlug(),
        ));
        
    }
    
    /**
     * @return \Media\Form\CommentForm
     */
    public function getCommentForm()
    {
        if ($this->commentForm === null) {
            return $this->commentForm = $this->getServiceLocator()->get(
                'media.form.comment'
            );
        }
        
        return $this->commentForm;
    }
    
    /**
     * @return \Media\Mapper\CommentMapperInterface
     */
    public function getCommentMapper()
    {
        if ($this->commentMapper === null) {
            return $this->commentMapper = $this->getServiceLocator()->get(
                'media.mapper.comment'
            );
        }
        
        return $this->commentMapper;
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        if ($this->mediaMapper === null) {
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
