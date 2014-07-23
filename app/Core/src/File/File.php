<?php

namespace Core\File;

use Core\File\Exception\FileException;
use Core\File\Exception\FileNotFoundException;
use Core\File\Extension\ExtensionGuesser;
use Core\File\MimeType\MimeTypeGuesser;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class File extends \SplFileInfo
{
    /**
     * @param string  $path
     * @param bool    $checkPath
     */
    public function __construct($path, $checkPath = true)
    {
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
    }
    
    /**
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->getBasename(), PATHINFO_EXTENSION);
    }
    
    /**
     * @return string
     */
    public function getMimeType()
    {
        $guesser = MimeTypeGuesser::getInstance();

        return $guesser->guess($this->getPathname());
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getName($name)
    {
        $originalName = str_replace('\\', '/', $name);
        $pos          = strrpos($originalName, '/');

        return ($pos === false) ? $originalName : substr($originalName, $pos + 1);
    }
    
    /**
     * @param string $directory
     * @param string $name
     *
     * @return \Core\File\File
     */
    protected function getTargetFile($directory, $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
        }

        $target = rtrim($directory, '/\\').DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));

        return new File($target, false);
    }
    
    /**
     * @return string
     */
    public function guessExtension()
    {
        $guesser = ExtensionGuesser::getInstance();

        return $guesser->guess($this->getMimeType());
    }
    
    /**
     * @param string $directory
     * @param string $name
     *
     * @return \Core\File\File
     */
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        if (!@rename($this->getPathname(), $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }

}
