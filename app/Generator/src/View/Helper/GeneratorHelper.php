<?php

namespace Generator\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Generator\Entity\PrototypeEntityInterface;
use Generator\Mapper\PrototypeMapperInterface;
use Generator\Options\ModuleOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorHelper extends AbstractHelper
{    
    /**
     * @var \Generator\Mapper\MediaMapperInterface
     */
    protected $prototypeMapper;

    /**
     * @var \Generator\Options\ModuleOptions $options
     */
    protected $options;
    
    /**
     * @param \Generator\Mapper\PrototypeMapperInterface $prototypeMapper
     * @param \Generator\Options\ModuleOptions           $options
     */
    public function __construct(
        PrototypeMapperInterface $prototypeMapper,
        ModuleOptions $options
    ) {
        $this->mediaMapper  = $prototypeMapper;
        $this->options      = $options;
    }
    
    /**
     * {@inheritDoc}
     */
    public function __invoke()
    {
        return $this;
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
        $bucketUrl = $this->options->getBucketUrl();
        
        // Return original image
        return $bucketUrl . $prototype->getReference();
    }
    
}
