<?php

namespace Media\Metadata;

use Media\Entity\MediaEntityInterface;

interface MetadataBuilderInterface
{
    /**
     * Return metadata for the media object.
     *
     * @param \Media\Entity\MediaEntityInterface $media
     * @param String                             $filename
     *
     * @return Array
     */
    public function getMetadata(MediaEntityInterface $media, $filename);
}
