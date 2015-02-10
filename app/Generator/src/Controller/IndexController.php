<?php
namespace Generator\Controller;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\File\Exists;
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
     * @var \Generator\Form\PreviewForm
     */
    protected $previewForm;
    
    /**
     * @var \Generator\Form\PublishForm
     */
    protected $publishForm;
    
    /**
     * @return array
     */
    public function indexAction()
    {
        // Check if user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Select all rows
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
        // Check if user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Select a row
        $generator = $this->getPrototypeMapper()->selectRowBySlug(
            $this->params()->fromRoute('slug')
        );
        
        // Check if row exists
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
        if (!$prototypeForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'form'      => $prototypeForm,
                'generator' => $generator,
            ));
        }
        
        // Get data
        $data = $prototypeForm->getData();
        /*
        // Get validator
        $validator = new Exists('public/media/generator');
        
        // Check if file does not exist
        if (!$validator->isValid(sprintf("%s.jpg", $data['token']))) {
            // Redirect to route
            return $this->redirect()->toRoute('generator');
        } */
                        
        // Process form
        if (isset($data['download'])) {      
            
            /*
            // Path to file
            $file = sprintf("public/media/generator/%s.jpg", $data['token']);
            // Get response
            $response = $this->getResponse();
            // Set content
            $response->setContent(file_get_contents($file));
            // Get headers
            $headers = $response->getHeaders();
            // Set headers
            $headers
                ->clearHeaders()
                ->addHeaderLine('Content-Type', 'application/force-download')
                ->addHeaderLine('Content-Disposition',  sprintf('attachment; filename="%s"', $generator->getName() . '.jpg'))
            ;
            // Return response
            return $response; */
        }
        else if (isset($data['publish'])) {
            // Flash messenger
            $fm = $this->flashMessenger()->setNamespace('generator.index.publish');
            // Add message
            $fm->addMessage(array('token' => $data['token']));
            // Forward to publish
            return $this->redirect()->toRoute('generator/publish');
        }
       
        // Redirect to route
        return $this->redirect()->toRoute('edit', array(
            'slug' => $generator->getSlug(),
        ));
    }
    
    /**
     * @return array
     */
    public function saveAction()
    {
        echo 'console.log("NOTRI SEM");';
        
        // Get request
        $request = $this->getRequest();
        
        // Check if request is not JSON
        if (!$request->isXmlHttpRequest()) {
            // Redirect user to home
            return $this->redirect()->toRoute('home');
        }
        
        // Check if user is not logged in
        if (!$this->user()->hasIdentity()) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'not_logged_in',
            ));
        }
        
        // Check if page is not posted
        if (!$request->isPost()) {
            // Return JSON
            return new JsonModel(array(
                'result' => 'not_post',
            ));
        }
        
        // Get form
        $previewForm = $this->getPreviewForm();
        
        // Set form data
        $previewForm->setData($request->getPost());
        
        // Check if for is not valid
        if (!$previewForm->isValid()) {
            // Return JSON
            return new JsonModel(array(
                'result'   => 'not_valid',
                'messages' => $previewForm->getMessages(),
            ));
        }
        
        // Get data
        $data = $previewForm->getData();
        
        // Process the image
        $name = $data['token'];
                        
        // Location of created image
        $location = '/media/generator/';

        // Relative path to the file
        $relPath = $location . $name . '.png';

        // Absolute path to the file
        $absPath = 'public' . $relPath;
        
          
	// requires php5
	define('UPLOAD_DIR', 'images/');
        
	$img =  $data['imgBase64'];
        
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
        
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
        
	$success = file_put_contents($file, $data);
        
	print $success ? $file : 'Unable to save the file.';

     
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
        // Check if user is not logged in
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
        $publishForm = $this->getPublishForm();
        
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
            
            // Get token
            $token = $messages[0]['token'];
            
            /*
            // Get validator
            $validator = new Exists('public/media/generator');
            
            // Check if file does not exist
            if (!$validator->isValid(sprintf("%s.jpg", $token))) {
                // Redirect to route
                return $this->redirect()->toRoute('generator');
            } */
            
            // Set token value
            $publishForm->setTokenValue($token);
            
            // Return view
            return new ViewModel(array(
                'publishForm' => $publishForm,
            )); 
        }
                     
        // Bind entity
        $publishForm->bind(new \Media\Entity\MediaEntity());
        
        // Set data
        $publishForm->setData($prg);
                
        // Check if form is not valid
        if (!$publishForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'publishForm' => $publishForm,
            ));
        }
        
        // Get data
        $media = $publishForm->getData();
        
        // Get token
        $token = $publishForm->get('token')->getValue();
        
        // Get validator
        $validator = new Exists('public/media/generator');
        
        // Check if file does not exist
        if (!$validator->isValid(sprintf("%s.jpg", $token))) {
            // Redirect to route
            return $this->redirect()->toRoute('generator');
        }
        
        // Set user
        $media->setUserId($this->user()->getIdentity()->getId());
        
        // Get file
        $file = sprintf('public/media/generator/%s.jpg', $token);
        
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
     * Return the preview form.
     *
     * @return \Generator\Form\PreviewForm
     */
    public function getPreviewForm()
    {
        if ($this->previewForm === null) {
            return $this->previewForm = $this->getServiceLocator()->get(
                'generator.form.preview'
            );
        }
        return $this->previewForm;
    }
    
    /**
     * Return the upload form.
     *
     * @return \Generator\Form\PublishForm
     */
    public function getPublishForm()
    {
        if ($this->publishForm === null) {
            return $this->publishForm = $this->getServiceLocator()->get(
                'generator.form.publish'
            );
        }
        return $this->publishForm;
    }
}