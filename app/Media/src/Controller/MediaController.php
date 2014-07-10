<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Media\Form\MediaForm;

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Aws\Common\Aws;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;
use Guzzle\Http\EntityBody;

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
                
                $this->uploadFile($file['name'], $file['tmp_name']);
                
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
                'media.form.media_form'
            );
        }
        
        return $this->mediaForm;
    }
    
    /**
     * @param type $file_name
     * @param type $source_file
     * @return type
     */
    public function uploadFile($file_name, $source_file)
    {
        $aws    = $this->getServiceLocator()->get('aws');
        $client = $aws->get('s3');
        
        // Try upload the file
        $client->putObject(array(
            'Bucket' => "gagchan",
            'Key'    => $file_name,
            'Body'   => fopen($source_file, 'r'),
            'ACL'    => 'public-read',
        ));
 
        /*
        return $client->waitUntilObjectExists(array(
            'Bucket' => $this->_bucket,
            'Key'    => $file_name
        )); */
    }
 
}