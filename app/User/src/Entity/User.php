<?php

namespace User\Entity;

use Core\Utils\Transliterator;
use ZfcUser\Entity\UserInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class User implements UserInterface
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
     * @var Integer
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
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        
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
     * {@inheritDoc}
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
    public function getDisplayName()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function setDisplayName($displayName)
    {
        if ($this->username === null) {
            // Transliterate string
            $username = Transliterator::transliterate($displayName);
            
            // Replace non-alphanum characters
            $username = preg_replace('/[^a-zA-Z\d\s]/', '', strtolower($username));

            // Replace whitespaces
            $username = preg_replace('/[\s]+/', '.', trim($username));
            
            // Set username
            $this->username = $username;
        }
        
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
     * {@inheritDoc}
     */
    public function setPassword($password)
    {
        if ($password === 'facebookToLocalUser' || $password === 'googleToLocalUser') {
            // Reset password
            $password = null;
        }
        
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
     * {@inheritDoc}
     */
    public function setState($state)
    {
        $this->state = $state;
        
        return $this;
    }
}
