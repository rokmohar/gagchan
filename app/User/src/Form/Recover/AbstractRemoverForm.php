<?php

namespace User\Form\Recover;

use Zend\Form\Form;

use User\Mapper\RecoverMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractRecoverForm extends Form implements RecoverFormInterface
{
    /**
     * @var \User\Mapper\RecoverMapperInterface
     */
    protected $recoverMapper;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \User\Mapper\RecoverMapperInterface $recoverMapper
     * @var \User\Mapper\UserMapperInterface    $userMapper
     */
    public function __construct(RecoverMapperInterface $recoverMapper, UserMapperInterface $userMapper)
    {
        parent::__construct();
        
        $this->recoverMapper = $recoverMapper;
        $this->userMapper    = $userMapper;
        
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
    public function addRecoveredAt()
    {
        $this->add(array(
            'name' => 'recovered_at',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addIsRecovered()
    {
        $this->add(array(
            'name' => 'is_recovered',
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
    public function getRecoverMapper()
    {
        return $this->recoverMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
}