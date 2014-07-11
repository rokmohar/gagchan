<?php

namespace Web\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Media\Mapper\MediaMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * Access URI: /web/index/index
     */
    public function indexAction()
    {
        // Select a media list from DB
        $media = $this->getMediaMapper()->selectAll();
        
        // Retun view
        return new ViewModel(array(
            'media' => $media,
        ));
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        if (!$this->mediaMapper instanceof MediaMapperInterface) {
            // Load from service locator
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
