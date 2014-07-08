<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface UserInterface
{
    /**
     * Return the identifier.
     *
     * @return Integer
     */
    public function getId();

    /**
     * Return the username.
     *
     * @return String
     */
    public function getUsername();

    /**
     * Return the email address.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Return the encrypted password.
     *
     * @return String
     */
    public function getPassword();

    /**
     * Return the created at datetime.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Return the updated at datetime.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}