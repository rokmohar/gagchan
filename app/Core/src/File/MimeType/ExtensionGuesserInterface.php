<?php

namespace Core\File\MimeType;

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