<?php

namespace User\Form;

use Zend\Form\Form;

use User\Mapper\ConfirmationMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationForm extends Form implements ConfirmationFormInterface
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
     * @var \User\Mapper\ConfirmationMapperInterface $confirmationMapper
     */
    public function __construct(
        ConfirmationMapperInterface $confirmationMapper,
        UserMapperInterface $userMapper
    ) {
        parent::__construct();
        
        // Set confirmation mapper
        $this->setConfirmationMapper($confirmationMapper);
        
        // Set user mapper
        $this->setUserMapper($userMapper);
        
        // Add elements
        $this
            ->addId()
            ->addUserId()
            ->addEmail()
            ->addRemoteAddress()
            ->addRequestAt()
            ->addRequestToken()
            ->addConfirmedAt()
            ->addIsConfirmed()
            ->addCreatedAt()
            ->addUpdatedAt()
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addId()
    {
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
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
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper)
    {
        $this->confirmationMapper = $confirmationMapper;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }
}