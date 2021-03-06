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
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function insertRow(MediaEntityInterface $media);
    
    /**
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order);
    
    /**
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
    
    /**
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function updateRow(MediaEntityInterface $media);
}
