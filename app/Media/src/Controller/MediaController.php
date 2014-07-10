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
                
                // Get file information
                //$fileinfo = $mediaForm->get('file')->getValue();
                
                $file = new \SplFileInfo(tmpfile());
                
                //header('Content-type: image/jpeg');
                //echo file_get_contents($url);
                
                die();
                
                // Create uploaded file
                /*$file = new UploadedFile(
                    $fileinfo['tmp_name'],
                    $fileinfo['name'],
                    $fileinfo['type'],
                    $fileinfo['size'],
                    $fileinfo['error']
                );*/
                
                // Media manager
                //$mediaManager = $this->getMediaManager();
                //$mediaManager->uploadFile($file, $name);
                
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
