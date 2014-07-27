<?php

namespace Generator\Controller;

use Zend\Http\Response;
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
     * @var \Generator\Form\GeneratorForm
     */    
    protected $generatorForm;
    
    /**
     * @var \Media\Service\MediaManagerInterface
     */
    protected $mediaManager;
    
    /**
     * @var \Generator\Mapper\PrototypeMapperInterface
     */
    protected $prototypeMapper;
    
    /**
     * @var \Generator\Form\UploadForm
     */    
    protected $uploadForm;
    
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
        $prototypeForm = $this->getGeneratorForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'form'      => $prototypeForm,
                'generator' => $generator,
            ));
        }
        
        // Set data
        $prototypeForm->setData($prg);
        
        // Check if form is not valid
        if ($prototypeForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'form'      => $prototypeForm,
                'generator' => $generator,
            ));
        }
        
        // Get data
        $data = $prototypeForm->getData();
        
        // Process form
        if (isset($data['download'])) { 
            
        }
        else if (isset($data['publish'])) {
            // Flash messenger
            $fm = $this->flashMessenger()->setNamespace('generator.index.publish');
            
            // Add message
            $fm->addMessage(array('token' => $data['token']));
            
            // Forward to publish
            return $this->redirect()->toRoute('publish');
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
        return  new JsonModel(array(
            'name' => $name,
        ));
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
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get upload form
        $uploadForm = $this->getUploadForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Get flash messenger
            $fm = $this->flashMessenger()->setNamespace('generator.index.publish');

            // Get messages
            $messages = $fm->getMessages();

            // Check if messages exist
            if (!count($messages) || !array_key_exists('token', $messages[0])) {
                // Redirect to route
                return $this->redirect()->toRoute('generator');
            }

            // Set token value
            $uploadForm->setTokenValue($messages[0]['token']);

            // Return view
            return new ViewModel(array(
                'uploadForm' => $uploadForm,
            ));
        }
        
        // Bind entity
        $uploadForm->bind(new \Media\Entity\MediaEntity());
        
        // Set data
        $uploadForm->setData($prg);
        
        // Check if form is not valid
        if (!$uploadForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'uploadForm' => $uploadForm,
            ));
        }
        
        // Get data
        $media = $uploadForm->getData();
        
        // Set user
        $media->setUserId($this->user()->getIdentity()->getId());
        
        // Get file
        $file = sprintf('public/media/generator/%s.jpg',
            $uploadForm->get('token')->getValue()
        );
        
        // Create uploaded image
        $image = new UploadedFile(
            $file,
            basename($file)
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
     * Return the upload form.
     * 
     * @return \Generator\Form\UploadForm
     */
    public function getUploadForm()
    {
        if ($this->uploadForm === null) {
            return $this->uploadForm = $this->getServiceLocator()->get(
                'generator.form.publish'
            );
        }
        
        return $this->uploadForm;
    }
    
    /**
     * Return the session.
     * 
     * @return \Zend\Session\Container
     */
    public function getSession()
    {
        
    }
}