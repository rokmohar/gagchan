<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverEntity implements RecoverEntityInterface
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
    protected $recoveredAt;
    
    /**
     * @var bool
     */
    protected $isRecovered;
    
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
        $this->isRecovered = false;
        $this->recoveredAt = null;
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
    public function setRequestAt(\DateTime $requestedAt)
    {
        $this->requestAt = $requestedAt;
        
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
    public function getRecoveredAt()
    {
        return $this->recoveredAt;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setRecoveredAt(\DateTime $recoveredAt = null)
    {
        $this->recoveredAt = $recoveredAt;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function isRecovered()
    {
        return $this->isRecovered;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setIsRecovered($isRecovered)
    {
        $this->isRecovered = $isRecovered;
        
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
