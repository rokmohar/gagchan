<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationEntity implements ConfirmationEntityInterface
{
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $remoteAddress;
    
    /**
     * @var \DateTime
     */
    protected $requestAt;
    
    /**
     * @var string
     */
    protected $requestToken;
    
    /**
     * @var \DateTime
     */
    protected $confirmedAt;
    
    /**
     * @var bool
     */
    protected $isConfirmed;
    
    /**
     * @var \DateTime
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     */
    protected $updatedAt;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->requestAt   = new \DateTime();
        $this->isConfirmed = false;
        $this->confirmedAt = null;
        $this->createdAt   = new \DateTime();
        $this->updatedAt   = new \DateTime();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRemoteAddress()
    {
        return $this->remoteAddress;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setRemoteAddress($remoteAddress)
    {
        $this->remoteAddress = $remoteAddress;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRequestAt()
    {
        return $this->requestAt;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setRequestAt(\DateTime $requestAt)
    {
        $this->requestAt = $requestAt;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRequestToken()
    {
        return $this->requestToken;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setRequestToken($requestToken)
    {
        $this->requestToken = $requestToken;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfirmedAt()
    {
        return $this->confirmedAt;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setConfirmedAt(\DateTime $confirmedAt = null)
    {
        $this->confirmedAt = $confirmedAt;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function isConfirmed()
    {
        return $this->isConfirmed;
    }
    
    /**
     * Set whether is confirmed.
     * 
     * @param bool $isConfirmed
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set created at date.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set updatedAt at date.
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    /**
     * Pre-insert initialization.
     * 
     * @return \Media\Entity\CommentEntityInterface
     */
    public function preInsert()
    {
        $this->setRequestAt(new \DateTime());
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    
    /**
     * Pre-update initialization.
     * 
     * @return \Media\Entity\CommentEntityInterface
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
