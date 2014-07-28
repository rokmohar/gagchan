<?php

namespace Core\File\Extension;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ExtensionGuesser implements ExtensionGuesserInterface
{
    /**
     * @var \Core\File\Extension\ExtensionGuesser
     */
    private static $instance = null;

    /**
     * @var array
     */
    protected $guessers = array();

    /**
     * @return \Core\File\Extension\ExtensionGuesser
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            // Create an instance
            return self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct()
    {
        $this->register(new MimeTypeExtensionGuesser());
    }

    /**
     *
     * @param \Core\File\Extension\ExtensionGuesserInterface $guesser
     */
    public function register(ExtensionGuesserInterface $guesser)
    {
        array_unshift($this->guessers, $guesser);
        
        return $this;
    }

    /**
     * @param string $mimeType The mime type
     *
     * @return string
     */
    public function guess($mimeType)
    {
        foreach ($this->guessers as $guesser) {
            if (null !== $extension = $guesser->guess($mimeType)) {
                // Return extension
                return $extension;
            }
        }
        
        return null;
    }
}
