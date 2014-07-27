<?php

namespace Generator\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Generator\Entity\PrototypeEntityInterface;
use Generator\Mapper\PrototypeMapperInterface;
use Media\Options\ModuleOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PrototypeHelper extends AbstractHelper
{
    
    /**
     * @var \Generator\Mapper\PrototypeMapperInterface
     */
    protected $prototypeMapper;
    
    /**
     * @var \Media\Options\ModuleOptions
     */
    protected $mediaOptions;
    
    /**
     * @param \Generator\Mapper\PrototypeMapperInterface $prototypeMapper
     * @param \Media\Options\ModuleOptions               $mediaOptions
     */
    public function __construct(PrototypeMapperInterface $prototypeMapper, ModuleOptions $mediaOptions)
    {
        $this->prototypeMapper = $prototypeMapper;
        $this->mediaOptions    = $mediaOptions;
    }
    
    /**
     * Generate URL for prototype.
     * 
     * @param \Generator\Entity\PrototypeEntityInterface $prototype
     * 
     * @return string
     */
    public function url(PrototypeEntityInterface $prototype)
    {
        // Get bucket URL
        $bucketUrl = $this->mediaOptions->getBucketUrl();
        
        // Return original image
        return $bucketUrl . $prototype->getReference();
    }
}
