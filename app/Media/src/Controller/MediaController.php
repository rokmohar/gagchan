<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Media\Form\MediaForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaController extends AbstractActionController
{
    /**
     * @var \Media\Service\BucketManagerInterface
     */
    protected $bucketManager;
    
    /**
     * @var \Media\Form\MediaForm
     */
    protected $mediaForm;
    
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
                // Upload selected file
                
                //echo $file_name . " " . $source_file;
                $file = $mediaForm->get('file')->getValue();
                
                $this->getBucketManager()->uploadFile($file['name'], $file['tmp_name']);
                
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
     * @return \Media\Service\BucketManagerInterface
     */
    public function getBucketManager()
    {
        if (!$this->bucketManager instanceof BucketManagerInterface) {
            return $this->bucketManager = $this->getServiceLocator()->get(
                'media.service.bucket_manager'
            );
        }
        
        return $this->bucketManager;
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
}