<?php

namespace User\InputFilter\Recover;

use Zend\InputFilter\InputFilter;

use User\Mapper\RecoverMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractRecoverFilter extends InputFilter implements RecoverFilterInterface
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
        $this->recoverMapper = $recoverMapper;
        $this->userMapper    = $userMapper;
        
        // Build filter
        $this->buildFilter();
    }
    
    /**
     * Build input filter.
     */
    abstract protected function buildFilter();
    
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
    public function addRecoveredAt()
    {
        $this->add(array(
            'name'       => 'recovered_at',
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
    public function addIsRecovered()
    {
        $this->add(array(
            'name'     => 'is_recovered',
            'required' => false,
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
    public function getUserMapper()
    {
        return $this->userMapper;
    }
}