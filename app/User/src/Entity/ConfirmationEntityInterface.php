<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationEntityInterface
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
     * @param int $id
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
     * Return request at date.
     * 
     * @return \DateTime
     */
    public function getRequestAt();
    
    /**
     * Set request at date.
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
     * Return confirmed at date.
     * 
     * @return \DateTime
     */
    public function getConfirmedAt();
    
    /**
     * Set confirmed at date.
     * 
     * @param \DateTime
     */
    public function setConfirmedAt(\DateTime $confirmedAt);
    
    /**
     * Check whether user is confirmed.
     * 
     * @return bool
     */
    public function isConfirmed();
    
    /**
     * Set whether user is confirmed.
     * 
     * @param bool $isConfirmed
     */
    public function setIsConfirmed($isConfirmed);
    
    /**
     * Return created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set created at date.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);
    
    /**
     * Return updated at date.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * Set updated at date.
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
