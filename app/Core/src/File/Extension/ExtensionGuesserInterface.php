<?php
namespace Core\File\Extension;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ExtensionGuesserInterface
{
    /**
     * Makes a best guess for a file extension, given a mime type.
     *
     * @param string $mimeType
     *
     * @return string
     */
    public function guess($mimeType);
}