<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\File\UploadedFile;
use Media\Form\MediaForm;
use Media\Service\MediaManagerInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaController extends AbstractActionController
{
    /**
     * @var \Media\Form\MediaForm
     */
    protected $mediaForm;
    
    /**
     * @var \Media\Service\MediaManagerInterface
     */
    protected $mediaManager;
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function uploadAction()
    {
        // Instance of request
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
                // Name
                $name = $mediaForm->get('name')->getValue();
                $url  = $mediaForm->get('url')->getValue();
                
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
                
                // Get file information
                //$fileinfo = $mediaForm->get('file')->getValue();
                
                // Create uploaded file
                /*$file = new UploadedFile(
                    $fileinfo['tmp_name'],
                    $fileinfo['name'],
                    $fileinfo['type'],
                    $fileinfo['size'],
                    $fileinfo['error']
                );*/
                
                // Media manager
                $mediaManager = $this->getMediaManager();
                $mediaManager->uploadFile($file, $name);
                
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
}
