<?php

namespace User\Entity;

use Core\Utils\Transliterator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserEntity implements UserEntityInterface
{
    /**
     * @var Integer
     */
    protected $id;

    /**
     * @var String
     */
    protected $username;

    /**
     * @var String
     */
    protected $email;

    /**
     * @var String
     */
    protected $password;
    
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
     * @param Integer $id
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
     * @param String $username
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
     * @param String $email
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
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
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
}
