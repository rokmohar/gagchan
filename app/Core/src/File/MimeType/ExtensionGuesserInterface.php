<?php

namespace Core\File\MimeType;

interface ExtensionGuesserInterface
{
    /**
     * Makes a best guess for a file extension, given a mime type.
     *
     * @param String $mimeType
     * 
     * @return String
     */
    public function guess($mimeType);
}