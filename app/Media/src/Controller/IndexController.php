<?php

namespace Media\Controller;

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
        // Get request
        $request = $this->getRequest();
        
        // Get params from URL
        $slug = $this->params()->fromRoute('slug', null);
        
        // Select media by identifier
        $media = $this->getMediaMapper()->selectRowBySlug($slug);
        
        // Check if no match exists
        if (empty($media)) {
            // Media not found
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
                $data = $commentForm->getData();
                
                // Set entity data
                $data->setMediaId($media->getId());
                $data->setUserId($this->user()->getIdentity()->getId());
                
                // Insert comment
                $this->getCommentMapper()->insertRow($data);
                
                // Redirect to route
                return $this->redirect()->toRoute('gag', array(
                    'slug' => $media->getSlug(),
                ));
            }
        }
        
        // Get comments
        $comments = $this->getCommentMapper()->selectByMedia($media);
        
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
        // Check is user is not logged in
        if ($this->user()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $externalForm = $this->getExternalMediaForm();
        $uploadForm   = $this->getUploadMediaForm();
               
        // Check if form is posted
        if ($request->isPost() === true) {
            // Set entity class
            $externalForm->bind(new \Media\Entity\MediaEntity());
            
            // Set posted data
            $externalForm->setData($request->getPost());
            
            // Set entity class
            $uploadForm->bind(new \Media\Entity\MediaEntity());
            
            // Merge posted data and files
            $uploadForm->setData(array_merge(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            ));
            
            // Validate form
            if ($externalForm->isValid() === true) {
                // Get posted data
                $data = $externalForm->getData();
                
                // Get posted data
                $url = $externalForm->get('url')->getValue();
                
                // Get category
                $category = $this->getCategoryMapper()->selectRowById(
                    $data->getCategoryId()
                );
                
                // Get user
                $user = $this->user()->getIdentity();
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                
                // Temporary file
                $temp = tempnam(sys_get_temp_dir(), '');

                // Copy file from URL
                copy($url, $temp);

                // Image size
                $size = getimagesize($temp);

                // Create uploaded image
                $file = new UploadedImage(
                    $temp,
                    basename($url),
                    image_type_to_mime_type($size[2]),
                    filesize($temp)
                );

                // Set size
                $file->setWidth($size[0]);
                $file->setHeight($size[1]);
                
                // Upload image
                $mediaManager->uploadImage($file, $data->getName(), $user, $category);
                
                // Redirect to route
                return $this->redirect()->toRoute('home');
            }
            else if ($uploadForm->isValid() === true) {
                // Get posted data
                $data = $uploadForm->getData();
                
                // Get posted data
                $filedata = $uploadForm->get('file')->getValue();
                
                // Get category
                $category = $this->getCategoryMapper()->selectRowById(
                    $data->getCategoryId()
                );
                
                // Get user
                $user = $this->user()->getIdentity();
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                
                // Create uploaded image
                $file = new UploadedImage(
                    $filedata['tmp_name'],
                    $filedata['name'],
                    $filedata['type'],
                    $filedata['size']
                );
                
                // Upload image
                $mediaManager->uploadImage($file, $data->getName(), $user, $category);
                
                // Redirect to route
                return $this->redirect()->toRoute('home');
            }
        }
        
        // Return view
        return new ViewModel(array(
            'externalForm' => $externalForm,
            'uploadForm'   => $uploadForm,
        ));
    }
    
    /**
     * @return \Category\Service\CategoryManagerInterface
     */
    public function getCategoryMapper()
    {
        if ($this->categoryMapper === null) {
            return $this->categoryMapper = $this->getServiceLocator()->get(
                'category.mapper.category'
            );
        }
        
        return $this->categoryMapper;
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
     * @return \Media\Form\ExternalMediaForm
     */
    public function getExternalMediaForm()
    {
        if ($this->externalMediaForm === null) {
            return $this->externalMediaForm = $this->getServiceLocator()->get(
                'media.form.external_media'
            );
        }
        
        return $this->externalMediaForm;
    }
    
    /**
     * @return \Media\Form\UploadMediaForm
     */
    public function getUploadMediaForm()
    {
        if ($this->uploadMediaForm === null) {
            return $this->uploadMediaForm = $this->getServiceLocator()->get(
                'media.form.upload_media'
            );
        }
        
        return $this->uploadMediaForm;
    }
    
    /**
     * @return \Media\Service\MediaManagerInterface
     */
    public function getMediaManager()
    {
        if ($this->mediaManager === null) {
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
        if ($this->mediaMapper === null) {
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
