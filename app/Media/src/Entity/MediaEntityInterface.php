<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface MediaEntityInterface
{
    /**
     * @return Integer
     */
    public function getId();
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
}