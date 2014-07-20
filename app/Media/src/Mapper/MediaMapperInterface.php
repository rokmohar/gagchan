<?php

namespace Media\Mapper;

use Media\Entity\MediaEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function insertRow(MediaEntityInterface $media);
    
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
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function updateRow(MediaEntityInterface $media);
}
