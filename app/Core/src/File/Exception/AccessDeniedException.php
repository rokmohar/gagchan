<?php
namespace Core\File\Exception;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AccessDeniedException extends FileException
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct(sprintf("The file \"%s\" could not be accessed", $path));
    }
}