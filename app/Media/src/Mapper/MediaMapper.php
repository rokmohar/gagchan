<?php

namespace Media\Mapper;

use Core\Mapper\AbstractMapper;

class MediaMapper extends AbstractMapper implements MediaMapperInterface
{
    /**
     * @return Boolean
     */
    public function isUniqueSlug($slug)
    {
        // Yet to come ...
        return $slug === 'yes';
    }
}