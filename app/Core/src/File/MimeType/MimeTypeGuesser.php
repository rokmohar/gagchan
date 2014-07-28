<?php
namespace Core\File\MimeType;
use Core\File\Exception\AccessDeniedException;
use Core\File\Exception\FileNotFoundException;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MimeTypeGuesser implements MimeTypeGuesserInterface
{
    /**
     * @var \Core\File\MimeType\MimeTypeGuesser
     */
    private static $instance = null;
    /**
     * @var array
     */
    protected $guessers = array();
    /**
     * @return \Core\File\MimeType\MimeTypeGuesser
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
     * Registers all natively provided mime type guessers.
     */
    private function __construct()
    {
        if (FileBinaryMimeTypeGuesser::isSupported()) {
            $this->register(new FileBinaryMimeTypeGuesser());
        }
        if (FileinfoMimeTypeGuesser::isSupported()) {
            $this->register(new FileinfoMimeTypeGuesser());
        }
    }
    /**
     * @param \Core\File\MimeType\MimeTypeGuesserInterface $guesser
     */
    public function register(MimeTypeGuesserInterface $guesser)
    {
        array_unshift($this->guessers, $guesser);
    }
    /**
     * @param string $path
     *
     * @return string
     */
    public function guess($path)
    {
        if (!is_file($path)) {
            throw new FileNotFoundException($path);
        }
        if (!is_readable($path)) {
            throw new AccessDeniedException($path);
        }
        if (!$this->guessers) {
            throw new \LogicException('Unable to guess the mime type as no guessers are available.');
        }
        foreach ($this->guessers as $guesser) {
            if (null !== $mimeType = $guesser->guess($path)) {
                // Return mime type
                return $mimeType;
            }
        }
    }
}