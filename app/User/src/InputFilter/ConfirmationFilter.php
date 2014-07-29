<?php

namespace User\InputFilter;

use Zend\InputFilter\InputFilter;

use User\Mapper\ConfirmationMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationFilter extends InputFilter implements ConfirmationFilterInterface
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
     * @var \User\Mapper\UserMapperInterface         $userMapper
     */
    public function __construct(
        ConfirmationMapperInterface $confirmationMapper,
        UserMapperInterface $userMapper
    ) {
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
                        'mapper' => $this->getConfirmationMapper(),
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