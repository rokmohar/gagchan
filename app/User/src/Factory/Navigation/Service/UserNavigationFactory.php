<?php

namespace User\Factory\Navigation\Service;

use Zend\Navigation\Service\AbstractNavigationFactory;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'user';
    }
}
