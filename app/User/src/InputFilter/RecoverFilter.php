<?php

namespace User\InputFilter;

use Zend\InputFilter\InputFilter;

use User\Mapper\RecoverMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverFilter extends InputFilter implements RecoverFilterInterface
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
     * @var \User\Mapper\UserMapperInterface         $userMapper
     */
    public function __construct(
        RecoverMapperInterface $recoverMapper,
        UserMapperInterface $userMapper
    ) {
        // Set recover mapper
        $this->setRecoverMapper($recoverMapper);
        
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
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addId()
    {
        $this->add(array(
            'name'     => 'id',
            'required' => false,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
            'validators' => array(
                array(
                    'name'    => 'User\Validator\RecordExists',
                    'options' => array(
                        'field'  => 'id',
                        'mapper' => $this->getRecoverMapper(),
                    )
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addUserId()
    {
        $this->add(array(
            'name'     => 'user_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
            'validators' => array(
                array(
                    'name'    => 'User\Validator\RecordExists',
                    'options' => array(
                        'field'  => 'id',
                        'mapper' => $this->getUserMapper(),
                    )
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addEmail()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'User\Validator\RecordExists',
                    'options' => array(
                        'field'  => 'email',
                        'mapper' => $this->getUserMapper(),
                    )
                ),
                array('name' => 'Zend\Validator\EmailAddress'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRemoteAddress()
    {
        $this->add(array(
            'name'       => 'remote_address',
            'required'   => true,
            'validators' => array(
                array('name' => 'Zend\Validator\Ip'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRequestAt()
    {
        $this->add(array(
            'name'       => 'request_at',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Date',
                    'options' => array(
                        'format' => 'Y-m-d H:i:s',
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addRequestToken()
    {
        $this->add(array(
            'name'     => 'request_token',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addConfirmedAt()
    {
        $this->add(array(
            'name'       => 'confirmed_at',
            'required'   => false,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Date',
                    'options' => array(
                        'format' => 'Y-m-d H:i:s',
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addIsConfirmed()
    {
        $this->add(array(
            'name'     => 'is_confirmed',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Boolean'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addCreatedAt()
    {
        $this->add(array(
            'name'       => 'created_at',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Date',
                    'options' => array(
                        'format' => 'Y-m-d H:i:s',
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addUpdatedAt()
    {
        $this->add(array(
            'name'       => 'updated_at',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Date',
                    'options' => array(
                        'format' => 'Y-m-d H:i:s',
                    ),
                ),
            ),
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
    public function setRecoverMapper(RecoverMapperInterface $recoverMapper)
    {
        $this->recoverMapper = $recoverMapper;
        
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