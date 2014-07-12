<?php

namespace Media\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Media\Mapper\CommentMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class CommentHelper extends AbstractHelper
{
    /**
     * @var \Media\Mapper\CommentMapperInterface
     */
    protected $commentMapper;
    
    /**
     * @param \Media\Mapper\CommentMapperInterface $commentMapper
     */
    public function __construct(CommentMapperInterface $commentMapper)
    {
        $this->commentMapper = $commentMapper;
    }
    
    /**
     * __invoke
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * Return time passed.
     * 
     * @param \DateTime $date
     * 
     * @return String
     */
    public function dateDiff(\DateTime $date)
    {
        $diff = date_diff(date_create(), $date);

        if (1 == $diff->y) {
            return '1 year ago';
        }
        if (1 < $diff->y) {
            return sprintf("%s years ago", $diff->y);
        }
        else if (1 === $diff->m) {
            return '1 month ago';
        }
        else if (1 < $diff->m) {
            return sprintf("%s months ago", $diff->m);
        }
        else if (1 === $diff->d) {
            return '1 day ago';
        }
        else if (0 < $diff->d) {
            return sprintf("%s days ago", $diff->d);
        }
        else if (1 === $diff->h) {
            return '1 hour ago';
        }
        else if (0 < $diff->h) {
            return sprintf("%s hours ago", $diff->h);
        }
        else if (0 < $diff->i) {
            return sprintf("%s minutes ago", $diff->i);
        }
        
        return 'less than a mintue ago';
    }
}