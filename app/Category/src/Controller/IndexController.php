<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
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
        $category = $this->getCategoryMapper()->selectRowBySlug($slug);
        
        // Check if not match exists
        if (empty($category)) {
            // Category not found
            return $this->notFoundAction();
        }
        
        // Get params from query
        $page = (int) $this->params()->fromQuery('page', 1);
        
        // Select from database
        $media = $this->getMediaMapper()->selectLatestByCategory($category);
        $media->setCurrentPageNumber($page);
        
        // Set items per page
        $media->setItemCountPerPage(15);
        
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
                'category.mapper.category'
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
