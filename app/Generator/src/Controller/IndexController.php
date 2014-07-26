<?php

namespace Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

use Core\File\UploadedFile;
use Generator\Utils\MemeGenerator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     *
     * @var array 
     */
    protected $data;
    
    /**
     * @var \Generator\Form\GeneratorForm
     */    
    protected $generatorForm;
    
    /**
     * @var \Generator\Form\UploadForm
     */    
    protected $uploadForm;    
    
    /**
     * @var \Generator\Mapper\PrototypeMapperInterface
     */
    protected $prototypeMapper;    
    
    /**
     * @var \Generator\Options\ModuleOptions
     */
    protected $options;
    
    /**
     * @return array 
     */
    public function indexAction()
    {
        // Select from database
        $generator = $this->getPrototypeMapper()->selectAll();
        
        // Retun view
        return new ViewModel(array(
            'generator' => $generator,
        ));
    }
    
    /**
     * @return array 
     */
    public function editAction()
    {                
        // Select media
        $generator = $this->getPrototypeMapper()->selectRowBySlug(
            $this->params()->fromRoute('slug')
        );
               
        // Check if generator is empty
        if (empty($generator)) {
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
        
        // Get form
        $form = $this->getGeneratorForm();
        
        // Create generator for meme unique ID
        $tokenGenerator = \Core\Utils\TokenGenerator::getInstance();
        
        // Path to generated meme
        $filePath = '/media/generator/';

        // Generate unique ID of length 6
        while (file_exists($filePath . 
                $token = $tokenGenerator->getToken(6)) . 'jpg' == false);

        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'form'      => $form,
                'generator' => $generator,
                'token'     => $token,
            ));
        }
        
        // Set data
        $form->setData($prg);
        
        // Check if form is not valid
        if ($form->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'form'      => $form,
                'generator' => $generator,
                'token'     => $token,
            ));
        }
       
        // Get data
        $data = $form->getData();
        
        // Get options
        $options = $this->getPrototypeOptions();
        
        // Bucket URL
        $bucketUrl = $this->options->getBucketUrl();
        
        // Reference to image
        $ref = $generator->getReference();
        
        // Path to image
        $path = $bucketUrl . $ref;
        
        // Process download
        if (isset($data['download'])) { 
            
        // Generate publish
        } else if (isset($data['publish'])) {
            
            // Redirect to route
            return $this->redirect()->toRoute('publish', array(
                'token' => $token,
            ));
        
            // Create uploaded image
            $image = new UploadedFile(
                $filePath . $token . 'jpg',
                $file['name'],
                $file['type'],
                $file['size'],
                $file['error']
            );            
            
            // Delete image from server
            unlink($filePath . $token . 'jpg');
        }

        // Redirect to route
        return $this->redirect()->toRoute('edit', array(
            'slug' => $generator->getSlug(),
        ));     

    }
    
    /**
     * @return array 
     */  
    public function previewAction()
    {
        // Get data from ajax call
        // Top text
        $upmsg   = $_POST['upmsg'];
        
        // Bottom text
        $downmsg = $_POST['downmsg'];
        
        // Image (default) source
        $path    = $_POST['imgsrc'];
        
        // Image token (unique ID)
        $token   = $_POST['token'];

        // Generate meme
        $name = $this->generate($upmsg, $downmsg, $path, $token);
        
        // Retrun create image path
        return  new JsonModel(array('name' => $name));
    }
    
    /**
     * @return array 
     */       
    public function publishAction()
    {
        // Check is user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get reqest
        $request = $this->getRequest();
        
        // Get form
        $uploadForm = $this->getUploadForm();
        
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
        
        die("POSTED");
        
        // Get data
        $media = $uploadForm->getData();
        
        // Set user
        $media->setUserId($this->user()->getIdentity()->getId());

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
     * @return array 
     */    
    public function prototypeAction()
    {
        // Amazon storage
        $aws = $this->serviceLocator->get('aws');
        $client = $aws->get('s3');
        
        $iterator = $client->getIterator('ListObjects', array(
            'Bucket' => 'gagchan.dev',
            'Marker' => 'prototype/',
            'Prefix' => 'prototype/',
        ));
        
        /*$prototypeMapper = $this->getPrototypeMapper();
        
        foreach ($iterator as $object) {
            preg_match('/prototype\/([a-zA-Z0-9-]*).jpg/', $object['Key'], $matches);
            
            $slug = $matches[1];
            $name = str_replace('-', ' ', $matches[1]);
            
            $prototype = new \Generator\Entity\PrototypeEntity();
            
            $prototype->setSlug(strtolower($slug));
            $prototype->setName($name);
            $prototype->setReference('/' . strtolower(str_replace('-', '_', $object['Key'])));
            $prototype->setWidth(400);
            $prototype->setHeight(400);
            $prototype->setSize($object['Size']);
            $prototype->setContentType('image/jpeg');
            $prototype->setCreatedAt(new \DateTime());
            $prototype->setUpdatedAt(new \DateTime());
            
            $prototypeMapper->insertRow($prototype);
        }*/
        
        /*$result = $result = $client->headObject(array(
            'Bucket' => 'gagchan.dev',
            'Key'    => 'photo_prototype/10-Guy.jpg',
        ));
        
        var_dump($result);*/
        
        die();
    }
    
    /**
     * Generate the meme
     * 
     * @param array  $data
     * @param String $path
     */
    public function generate($topText, $bottomText, $path, $token)
    {           
        // Create new meme
        $img = new MemeGenerator($path);

        // Set top text
        $img->setTopText($topText);
        
        // Set bottom text
        $img->setBottomText($bottomText);

        // Process the image and return the file path
        return $img->processImg($token);
    }

    /**
     * Return the generator form.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    public function getGeneratorForm()
    {
        if ($this->generatorForm === null) {
            return $this->generatorForm = $this->getServiceLocator()->get(
                'generator.form.generator'
            );
        }
        
        return $this->generatorForm;
    }
    
    /**
     * Return the uplaod form.
     * 
     * @return \Generator\Form\UploadForm
     */
    public function getUploadForm()
    {
        if ($this->uploadForm === null) {
            return $this->uploadForm = $this->getServiceLocator()->get(
                'generator.form.upload'
            );
        }
        
        return $this->uploadForm;
    }    
    
    /**
     * @return \Generator\Mapper\PrototypeMapperInterface
     */
    public function getPrototypeMapper()
    {
        if ($this->prototypeMapper === null) {
            return $this->prototypeMapper = $this->getServiceLocator()->get(
                'generator.mapper.prototype'
            );
        }
        
        return $this->prototypeMapper;
    }    
    
    /**
     * @return \Generator\Options\ModuleOptions
     */
    public function getPrototypeOptions()
    {
        if ($this->options === null) {
            return $this->options = $this->getServiceLocator()->get(
                'generator.options.module'
            );
        }
        
        return $this->options;
    }     
}