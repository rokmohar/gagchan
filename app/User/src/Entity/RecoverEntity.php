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
     * Set the identifier.
     * 
     * @param int $id
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
     * Set the user identifier.
     * 
     * @param int $userId
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
     * Set the email address.
     * 
     * @param string $email
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
     * Set the remote address.
     * 
     * @param string $remoteAddress
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
     * Set the requested at date.
     * 
     * @param \DateTime $requestedAt
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
     * Set the request token.
     * 
     * @param string $requestToken
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
     * Set recovered at date.
     * 
     * @param \DateTime $recoveredAt
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
     * Set whether is recovered.
     * 
     * @param bool $isRecovered
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
     * Set updated at date.
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
