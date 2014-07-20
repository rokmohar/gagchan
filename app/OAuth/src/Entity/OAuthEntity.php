<?php

namespace OAuth\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthEntity implements OAuthEntityInterface
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
    protected $provider;
    
    /**
     * @var string
     */
    protected $providerId;
    
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
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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
    public function getProvider()
    {
        return $this->provider;
    }
    
    /**
     * Set the provider.
     * 
     * @param string $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getProviderId()
    {
        return $this->providerId;
    }
    
    /**
     * Set the provider identifier.
     * 
     * @param string $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        
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