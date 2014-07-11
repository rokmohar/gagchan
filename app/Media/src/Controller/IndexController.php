<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\File\UploadedFile;
use Media\Form\CommentForm;
use Media\Form\MediaForm;
use Media\Service\MediaManagerInterface;

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
    public function detailsAction()
    {
        // Get request
        $request = $this->getRequest();
        
        // Get params from URL
        $slug = $this->params()->fromRoute('slug', null);
        
        // Select media by identifier
        $media = $this->getMediaMapper()->selectOneBySlug($slug);
        
        // Check if media is found
        if (empty($media) === true) {
            // Media not found
            return $this->notFoundAction();
        }
        
        // Get form
        $commentForm = $this->getCommentForm();
        
        // Check if form is posted
        if ($request->isPost() === true) {
            // Set form data
            $commentForm->setData($request->getPost());
            
            // Validate form
            if ($commentForm->isValid() === true) {
                // Get posted data
                $comment = $commentForm->get('comment')->getValue();
                
                // Insert comment into DB
                $this->getCommentMapper()->insertOne(
                    $media['id'],
                    $this->zfcuserAuthentication()->getIdentity()->getId(),
                    $comment
                );
            }
            
            // Redirect to media page
            return $this->redirect()->toRoute('gag', array(
                'slug' => $media['slug'],
            ));
        }
        
        // Get comments for media
        $comments = $this->getCommentMapper()->selectAllByMedia($media['id']);
        
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
        if ($this->zfcuserAuthentication()->hasIdentity() === false) {
            // Redirect user to the login page
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get an instance of media form
        $mediaForm = $this->getMediaForm();
        
        // Check if form is posted
        if ($request->isPost() === true) {
            // Set posted data
            $mediaForm->setData(array_merge(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            ));
            
            // Validate form
            if ($mediaForm->isValid() === true) {
                // Get posted data
                $name     = $mediaForm->get('name')->getValue();
                $file     = $mediaForm->get('file')->getValue();
                $url      = $mediaForm->get('url')->getValue();
                $category = $mediaForm->get('category')->getValue();
                
                if (empty($file) === true && empty($url) === true) {
                    throw new \Exception(
                        'File or external URL is required.'
                    );
                }
                else if (empty($file) === true) {
                    // Temporary file name
                    $temp = tempnam(false, false);

                    // Copy image from URL to temporary file
                    copy($url, $temp);

                    // Image size
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
                    // Create uploaded file
                    $file = new UploadedFile(
                        $file['tmp_name'],
                        $file['name'],
                        $file['type'],
                        $file['size'],
                        $file['error']
                    );
                }
                
                // Get user identifier
                $userId = $this->zfcuserAuthentication()->getIdentity()->getId();
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                $mediaManager->uploadFile($file, $name, $userId, $category);
                
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
        if (!$this->commentForm instanceof CommentForm) {
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
        if (!$this->commentMapper instanceof CommentMapperInterface) {
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
        if (!$this->mediaForm instanceof MediaForm) {
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
        if (!$this->mediaManager instanceof MediaManagerInterface) {
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
        if (!$this->mediaMapper instanceof MediaMapperInterface) {
            // Load from service locator
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
