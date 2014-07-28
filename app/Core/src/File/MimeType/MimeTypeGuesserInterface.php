<?php
namespace Core\File\MimeType;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MimeTypeGuesserInterface
{
    /**
     * @param string $path
     *
     * @return string
     */
    public function guess($path);
}