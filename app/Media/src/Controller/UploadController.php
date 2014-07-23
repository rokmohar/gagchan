<?php

namespace Media\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\File\UploadedFile;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadController extends AbstractActionController
{
    /**
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
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
     * @return \Zend\View\Helper\ViewModel
     */
    public function indexAction()
    {
        // Check is user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get reqest
        $request = $this->getRequest();
        
        // Get form
        $uploadForm = $this->getUploadMediaForm();
        
        // Check if page is not posted
        if (!$request->isPost()) {
            // Return view
            return new ViewModel(array(
                'uploadForm' => $uploadForm,
            ));
        }
        
        // Bind entity
        $uploadForm->bind(new \Media\Entity\MediaEntity());

        // Set data
        $uploadForm->setData(array_merge(
            $request->getPost()->toarray(),
            $request->getFiles()->toarray()
        ));
        
        // Check if form is not valid
        if (!$uploadForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'uploadForm' => $uploadForm,
            ));
        }
        
        // Get data
        $media = $uploadForm->getData();

        // Get posted data
        $file = $uploadForm->get('file')->getValue();
        
        // Create uploaded image
        $image = new UploadedFile(
            $file['tmp_name'],
            $file['name'],
            $file['type'],
            $file['size'],
            $file['error']
        );
        
        // Set user
        $media->setUserId($this->user()->getIdentity()->getId());

        // Set category
        $media->setCategoryId($uploadForm->get('category')->getValue());
        
        // Media manager
        $mediaManager = $this->getMediaManager();

        // Upload image
        $mediaManager->uploadImage($image, $media);
        
        // Redirect to route
        return $this->redirect()->toRoute('gag', array(
            'slug' => $media->getSlug(),
        ));
    }
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function externalAction()
    {
        // Check is user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get form
        $externalForm = $this->getExternalMediaForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'externalForm' => $externalForm,
            ));
        }
        
        // Bind entity
        $externalForm->bind(new \Media\Entity\MediaEntity());

        // Set data
        $externalForm->setData($prg);
        
        // Check if form is not valid
        if (!$externalForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'externalForm' => $externalForm,
            ));
        }
        // Get data
        $media = $externalForm->getData();

        // Get posted data
        $url = $externalForm->get('url')->getValue();

        // Set user
        $media->setUserId($this->user()->getIdentity()->getId());

        // Set category
        $media->setCategoryId($externalForm->get('category')->getValue());

        // Temporary file
        $temp = tempnam(sys_get_temp_dir(), '');

        // Copy file from URL
        copy($url, $temp);

        // Image size
        $size = getimagesize($temp);
        
        // Create uploaded image
        $file = new UploadedFile(
            $temp,
            basename($url),
            image_type_to_mime_type($size[2]),
            filesize($temp)
        );

        // Media manager
        $mediaManager = $this->getMediaManager();

        // Upload image
        $mediaManager->uploadImage($file, $media);

        // Redirect to route
        return $this->redirect()->toRoute('gag', array(
            'slug' => $media->getSlug(),
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
}
