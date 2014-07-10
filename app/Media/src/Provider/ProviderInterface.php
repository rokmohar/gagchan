<?php

namespace Media\Provider;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Return the provider name.
     * 
     * @return String
     */
    public function getName();
}