<?php

namespace User\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserOptions extends AbstractOptions implements UserOptionsInterface
{
    /**
     * @var bool
     */
    protected $__strictMode__ = false;
    
    /**
     * @var string
     */
    protected $confirmationEntityClass = 'User\Entity\ConfirmationEntity';
    
    /**
     * @var string
     */
    protected $confirmationHydratorClass = 'User\Hydrator\ConfirmationHydrator';
    
    /**
     * @var string
     */
    protected $confirmationMapperClass = 'User\Mapper\ConfirmationMapper';
    
    /**
     * @var string
     */
    protected $recoverEntityClass = 'User\Entity\RecoverEntity';
    
    /**
     * @var string
     */
    protected $recoverHydratorClass = 'User\Hydrator\RecoverHydrator';
    
    /**
     * @var string
     */
    protected $recoverMapperClass = 'User\Mapper\RecoverMapper';
    
    /**
     * @var string
     */
    protected $userEntityClass = 'User\Entity\UserEntity';
    
    /**
     * @var string
     */
    protected $userHydratorClass = 'User\Hydrator\UserHydrator';
    
    /**
     * @var string
     */
    protected $userMapperClass = 'User\Mapper\UserMapper';
    
    /**
     * @var string
     */
    protected $userFormClass = 'User\Form\UserForm';
    
    /**
     * @var string
     */
    protected $userFilterClass = 'User\InputFilter\UserFilter';
    
    /**
     * @var string
     */
    protected $mailerClass = 'User\Mailer\AmazonMailer';
    
    /**
     * @var string
     */
    protected $managerClass = 'User\Manager\User';
    
    /**
     * @return string
     */
    public function getConfirmationEntityClass()
    {
        return $this->confirmationEntityClass;
    }
    
    /**
     * @param string $confirmationEntityClass
     */
    public function setConfirmationEntityClass($confirmationEntityClass)
    {
        $this->confirmationEntityClass = $confirmationEntityClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getConfirmationHydratorClass()
    {
        return $this->confirmationHydratorClass;
    }
    
    /**
     * @param string $confirmationHydratorClass
     */
    public function setConfirmationHydratorClass($confirmationHydratorClass)
    {
        $this->confirmationHydratorClass = $confirmationHydratorClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getConfirmationHydratorMapper()
    {
        return $this->confirmationHydratorMapper;
    }
    
    /**
     * @param string $confirmationHydratorMapper
     */
    public function setConfirmationHydratorMapper($confirmationHydratorMapper)
    {
        $this->confirmationHydratorMapper = $confirmationHydratorMapper;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getRecoverEntityClass()
    {
        return $this->recoverEntityClass;
    }
    
    /**
     * @param string $recoverEntityClass
     */
    public function setRecoverEntityClass($recoverEntityClass)
    {
        $this->recoverEntityClass = $recoverEntityClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getRecoverHydratorClass()
    {
        return $this->recoverHydratorClass;
    }
    
    /**
     * @param string $recoverHydratorClass
     */
    public function setRecoverHydratorClass($recoverHydratorClass)
    {
        $this->recoverHydratorClass = $recoverHydratorClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getRecoverHydratorMapper()
    {
        return $this->recoverHydratorMapper;
    }
    
    /**
     * @param string $recoverHydratorMapper
     */
    public function setRecoverHydratorMapper($recoverHydratorMapper)
    {
        $this->recoverHydratorMapper = $recoverHydratorMapper;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUserEntityClass()
    {
        return $this->userEntityClass;
    }
    
    /**
     * @param string $userEntityClass
     */
    public function setUserEntityClass($userEntityClass)
    {
        $this->userEntityClass = $userEntityClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUserHydratorClass()
    {
        return $this->userHydratorClass;
    }
    
    /**
     * @param string $userHydratorClass
     */
    public function setUserHydratorClass($userHydratorClass)
    {
        $this->userHydratorClass = $userHydratorClass;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUserHydratorMapper()
    {
        return $this->userHydratorMapper;
    }
    
    /**
     * @param string $userHydratorMapper
     */
    public function setUserHydratorMapper($userHydratorMapper)
    {
        $this->userHydratorMapper = $userHydratorMapper;
        
        return $this;
    }
}