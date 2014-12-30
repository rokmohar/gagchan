<?php

namespace User\Form\Confirmation;

use Zend\Form\Form;

use User\Mapper\ConfirmationMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractConfirmationForm extends Form implements ConfirmationFormInterface
{
    /**
     * @var \User\Mapper\ConfirmationMapperInterface
     */
    protected $confirmationMapper;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @param \User\Mapper\ConfirmationMapperInterface $confirmationMapper
     * @param \User\Mapper\UserMapperInterface         $userMapper
     */
    public function __construct(ConfirmationMapperInterface $confirmationMapper, UserMapperInterface $userMapper)
    {
        parent::__construct();
        
        $this->confirmationMapper = $confirmationMapper;
        $this->userMapper         = $userMapper;
        
        // Build form
        $this->buildForm();
    }
    
    /**
     * Build form.
     */
    abstract protected function buildForm();
    
    /**
     * {@inheritDoc}
     */
    public function addUserId()
    {
        $this->add(array(
            'name' => 'user_id',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addEmail()
    {
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRemoteAddress()
    {
        $this->add(array(
            'name' => 'remote_address',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRequestAt()
    {
        $this->add(array(
            'name' => 'request_at',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRequestToken()
    {
        $this->add(array(
            'name' => 'request_token',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addConfirmedAt()
    {
        $this->add(array(
            'name' => 'confirmed_at',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addIsConfirmed()
    {
        $this->add(array(
            'name' => 'is_confirmed',
            'type' => 'Zend\Form\Element\Checkbox',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addCreatedAt()
    {
        $this->add(array(
            'name' => 'created_at',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addUpdatedAt()
    {
        $this->add(array(
            'name' => 'updated_at',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfirmationMapper()
    {
        return $this->confirmationMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
}
