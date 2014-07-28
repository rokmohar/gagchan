<?php

namespace Generator\Form;

use Zend\Form\Form;

use Core\Utils\TokenGenerator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorForm extends Form
{
    /**
     * Constructor.
     */    
    public function __construct()
    {
        parent::__construct();

        // Add elements
        $this
            ->addCsrf()
            ->addTop()
            ->addBottom()
            ->addToken()
            ->addDownload()
            ->addPublish()
        ;
    }
    
    /**
     * Add the CSRF element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    protected function addCsrf()
    {
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        return $this;
    }
    
    /**
     * Add the top text element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    protected function addTop()
    {
        $this->add(array(
            'name'    => 'top',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Top Text',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Top Text',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the bottom text element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    protected function addBottom()
    {
        $this->add(array(
            'name'    => 'bottom',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Bottom Text',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Bottom Text',
            ),            
        ));
        
        return $this;
    }
    
    /**
     * Add the token element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    protected function addToken()
    {
        $this->add(array(
            'name'       => 'token',
            'type'       => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $this->generateToken(),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the download form element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    public function addDownload()
    {
        $this->add(array(
            'name'    => 'download',
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Download',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Download',
            ),
        ));
        
        return $this;
    }    
    
    /**
     * Add the publish form element.
     * 
     * @return \Generator\Form\GeneratorForm
     */
    public function addPublish()
    {
        $this->add(array(
            'name'    => 'publish',
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Publish',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Publish',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Generate a token.
     * 
     * @param int $length
     * 
     * @return string
     */
    protected function generateToken($length = 6)
    {
        // Get token generator
        $tokenGenerator = TokenGenerator::getInstance();
        
        // Generate token
        return $tokenGenerator->getToken($length);
    }
}
