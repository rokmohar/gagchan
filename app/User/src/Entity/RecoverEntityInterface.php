<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Set the identifier.
     * 
     * @param int
     */
    public function setId($id);
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Set the user identifier.
     * 
     * @param int $userId
     */
    public function setUserId($userId);
    
    /**
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Set the email address.
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Return the remote address.
     * 
     * @return string
     */
    public function getRemoteAddress();
    
    /**
     * Set the remote address.
     * 
     * @param string $remoteAddress
     */
    public function setRemoteAddress($remoteAddress);
    
    /**
     * Return the requested at date.
     * 
     * @return \DateTime
     */
    public function getRequestAt();
    
    /**
     * Set the requested at date.
     * 
     * @param \DateTime $requestAt
     */
    public function setRequestAt(\DateTime $requestAt);
    
    /**
     * Return the request token.
     * 
     * @return string
     */
    public function getRequestToken();
    
    /**
     * Set the request token.
     * 
     * @param string $requestToken
     */
    public function setRequestToken($requestToken);
    
    /**
     * Return the recovered at date.
     * 
     * @return \DateTime
     */
    public function getRecoveredAt();
    
    /**
     * Set the recovered at date.
     * 
     * @param \DateTime $recoveredAt
     */
    public function setRecoveredAt(\DateTime $recoveredAt);
    
    /**
     * Check whether is recovered.
     * 
     * @return bool
     */
    public function isRecovered();
    
    /**
     * Set whether is recovered.
     * 
     * @param bool $isRecovered
     */
    public function setIsRecovered($isRecovered);
    
    /**
     * Return the created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set the created at date.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);
    
    /**
     * Return the updated at date.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * Set the updated at date.
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
