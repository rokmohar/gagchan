<?php
namespace Core\File\Exception;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class FileNotFoundException extends FileException
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct(sprintf("The file \"%s\" does not exist", $path));
    }
}