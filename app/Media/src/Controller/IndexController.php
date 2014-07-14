<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\File\UploadedFile;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Media\Form\CommentForm
     */
    protected $commentForm;
    
    /**
     * @var \Media\Mapper\CommentMapperInterface
     */
    protected $commentMapper;
    
    /**
     * @var \Media\Form\MediaForm
     */
    protected $mediaForm;
    
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
        // Get request
        $request = $this->getRequest();
        
        // Get params from URL
        $slug = $this->params()->fromRoute('slug', null);
        
        // Select media by identifier
        $media = $this->getMediaMapper()->selectRowBySlug($slug);
        
        // Check if media is not found
        if (empty($media)) {
            // Show not found page
            return $this->notFoundAction();
        }
        
        // Get comment form
        $commentForm = $this->getCommentForm();
        
        // Check if form is posted
        if ($request->isPost() === true) {
            // Bind entity class
            $commentForm->bind(new \Media\Entity\CommentEntity());
            // Set form data
            $commentForm->setData($request->getPost());
            
            // Validate form
            if ($commentForm->isValid() === true) {
                // Get posted data
                $comment = $commentForm->get('comment')->getValue();
                
                // Insert comment
                $this->getCommentMapper()->insertRow(
                    $media->getId(),
                    $this->zfcuserAuthentication()->getIdentity()->getId(),
                    $comment
                );
            }
        }
        
        // Get comments
        $comments = $this->getCommentMapper()->selectByMedia($media->getId());
        
        // Return view
        return new ViewModel(array(
            'commentForm' => $commentForm,
            'media'       => $media,
            'comments'    => $comments,
        ));
    }
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function uploadAction()
    {
        // Check is user is logged in
        if ($this->zfcUserAuthentication()->hasIdentity() === false) {
            // Redirect user to the login page
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get an instance of media form
        $mediaForm = $this->getMediaForm();
        
        // Check if form is posted
        if ($request->isPost() === true) {
            // Bind entity class
            $mediaForm->bind(new \Media\Entity\MediaEntity());
            
            // Merge posted data and files
            $mediaForm->setData(array_merge(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            ));
            
            // Validate form
            if ($mediaForm->isValid() === true) {
                // Get posted data
                $data = $mediaForm->getData();
                
                // Get posted data
                $file = $mediaForm->get('file')->getValue();
                $url  = $mediaForm->get('url')->getValue();
                
                if (!empty($file)) {
                    // Create uploaded file
                    $file = new UploadedFile(
                        $file['tmp_name'],
                        $file['name'],
                        $file['type'],
                        $file['size'],
                        $file['error']
                    );
                }
                else if (!empty($url)) {
                    // Temporary file name
                    $temp = tempnam(sys_get_temp_dir(), '');
                    
                    // Copy file from provided URL
                    copy($url, $temp);

                    // Image size (ignore error)
                    $size = getimagesize($temp);
                    
                    $file = new UploadedFile(
                        $temp,
                        basename($url),
                        image_type_to_mime_type($size[2]),
                        filesize($temp),
                        $size[0],
                        $size[1]
                    );
                }
                else {
                    throw new \Exception('File or external URL is required.');
                }
                
                // Get user identifier
                $userId = $this->zfcuserAuthentication()->getIdentity()->getId();
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                $mediaManager->uploadFile($file, $data->getName(), $userId, $data->getCategoryId());
                
                // Redirect to route
                return $this->redirect()->toRoute('home');
            }
        }
        
        // Prepare media form
        $mediaForm->prepare();
        
        // Return view
        return new ViewModel(array(
            'mediaForm' => $mediaForm,
        ));
    }
    
    /**
     * @return \Media\Form\CommentForm
     */
    public function getCommentForm()
    {
        // Check if service is loaded
        if ($this->commentForm === null) {
            // Load from service locator
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
        // Check if service is loaded
        if ($this->commentMapper === null) {
            // Load from service locator
            return $this->commentMapper = $this->getServiceLocator()->get(
                'media.mapper.comment'
            );
        }
        
        return $this->commentMapper;
    }
    
    /**
     * @return \Media\Form\MediaForm
     */
    public function getMediaForm()
    {
        // Check if service is loaded
        if ($this->mediaForm === null) {
            // Load from service locator
            return $this->mediaForm = $this->getServiceLocator()->get(
                'media.form.media'
            );
        }
        
        return $this->mediaForm;
    }
    
    /**
     * @return \Media\Service\MediaManagerInterface
     */
    public function getMediaManager()
    {
        // Check if service is loaded
        if ($this->mediaManager === null) {
            // Load from service locator
            return $this->mediaManager = $this->getServiceLocator()->get(
                'media.service.media_manager'
            );
        }
        
        return $this->mediaManager;
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        // Check if service is loaded
        if ($this->mediaMapper === null) {
            // Load from service locator
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
