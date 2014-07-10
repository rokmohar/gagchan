<?php

namespace Media\Service;

use Media\Mapper\MediaMapperInterface;

interface MediaManagerInterface
{
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
}
