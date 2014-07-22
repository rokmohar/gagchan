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
     * Set the request at date.
     * 
     * @param \DateTime $requestAt
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
     * Set the request token.
     * 
     * @param string $requestToken
     */
    public function setRequestToken($requestToken)
    {
        $this->requestAt = $requestToken;
        
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
     * Set confirmed at date.
     * 
     * @param \DateTime $confirmedAt
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
}
