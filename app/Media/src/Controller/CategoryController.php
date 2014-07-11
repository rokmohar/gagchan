<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryController extends AbstractActionController
{
    /**
     * @var \Media\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @return \Zend\View\Helper\ViewModel
     */
    public function indexAction()
    {
        // Get params from route
        $slug = $this->params()->fromRoute('slug', null);
        
        // Get category
        $category = $this->getCategoryMapper()->selectOneBySlug($slug);
        
        // Check if category exists
        if ($category === false) {
            // Category not found
            return $this->notFoundAction();
        }
        
        // Get media by category
        $media = $this->getMediaMapper()->selectAllByCategory($category['id']);
        
        // Return view
        return new ViewModel(array(
            'category' => $category,
            'media'    => $media,
        ));
    }
    
    /**
     * @return \Media\Mapper\CategoryMapperInterface
     */
    public function getCategoryMapper()
    {
        // Check if service is loaded
        if ($this->categoryMapper === null) {
            // Load from service locator
            return $this->categoryMapper = $this->getServiceLocator()->get(
                'media.mapper.category'
            );
        }
        
        return $this->categoryMapper;
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        // Check if service is loaded
        if ($this->mediaMapper === null) {
            // Load from service locator
            return $this->mediaMapper = $this->getServiceLocator()->get(
                'media.mapper.media'
            );
        }
        
        return $this->mediaMapper;
    }
}
