<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserEntity implements UserEntityInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;
    
    /**
     * @var int
     */
    protected $state;
    
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
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username.
     * 
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the password.
     * 
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Set the state.
     * 
     * @param int $state
     */
    public function setState($state)
    {
        $this->state = $state;
        
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
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
