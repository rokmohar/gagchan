<?php
namespace Contact\Model;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ContactModel implements ContactModelInterface
{
    /**
     * @var string
     */
    protected $remoteAddress;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $subject;
    /**
     * @var string
     */
    protected $message;
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
    public function getSubject()
    {
        return $this->subject;
    }
    /**
     * {@inheritDoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
    /**
     * {@inheritDoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * {@inheritDoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}