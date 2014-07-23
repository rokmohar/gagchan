<?php

namespace Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Generator\Utils\MemeGenerator;

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
     * @var \Generator\Mapper\PrototypeMapperInterface
     */
    protected $prototypeMapper;    
    
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
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $generatorForm = $this->getGeneratorForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'form' => $generatorForm,
            ));
        }
        
        // Set data
        $generatorForm->setData($request->getPost());
        
        // Check if form is not valid
        if ($generatorForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'error' => true,
                'form' => $generatorForm,
            ));
        }
        
        // Process the image
        $this->processImage($generatorForm->getData());
        
        // Redirect to route
        return $this->redirect()->toRoute('home');        
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
     * Process the image
     * 
     * @param array $data
     */
    public function processImage(array $data)
    {
        $topText    = $data['top'];
        $bottomText = $data['bottom'];
        
        // Path to image
        $path       = $this->params()->fromQuery;
        
        $obj = new MemeGenerator($path);
        
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
    
}