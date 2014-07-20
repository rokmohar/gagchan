<?php

namespace OAuth\Mapper;

use OAuth\Entity\OAuthEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface OAuthMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \OAuth\Entity\OAuthEntityInterface $oauth
     */
    public function insertRow(OAuthEntityInterface $oauth);
    
    /**
     * Select all rows.
     * 
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order);
    
    /**
     * Select a row.
     * 
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
    
    /**
     * Update a row.
     * 
     * @param \OAuth\Entity\OAuthEntityInterface $oauth
     */
    public function updateRow(OAuthEntityInterface $oauth);
}