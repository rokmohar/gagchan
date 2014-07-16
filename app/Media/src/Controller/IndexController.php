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
                $data->setUserId(
                    $this->zfcuserAuthentication()->getIdentity()->getId()
                );
                
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
        if ($this->zfcUserAuthentication()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $mediaForm = $this->getMediaForm();
        
        // Check if form is posted
        if ($request->isPost() === true) {
            // Set entity class
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
                
                // Get category
                $category = $this->getCategoryMapper()->selectRowById(
                    $data->getCategoryId()
                );
                
                // Get user
                $user = $this->zfcuserAuthentication()->getIdentity();
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                
                if (!empty($file)) {
                    // Create uploaded image
                    $file = new UploadedImage(
                        $file['tmp_name'],
                        $file['name'],
                        $file['type'],
                        $file['size'],
                        $file['error']
                    );
                }
                else if (!empty($url)) {
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
                }
                else {
                    throw new \Exception('File or external URL is required.');
                }
                
                // Upload image
                $mediaManager->uploadImage($file, $data->getName(), $user, $category);
                
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
     * @return \Media\Form\MediaForm
     */
    public function getMediaForm()
    {
        if ($this->mediaForm === null) {
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
