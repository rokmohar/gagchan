<?php
namespace Core\File\MimeType;
use Core\File\Exception\AccessDeniedException;
use Core\File\Exception\FileNotFoundException;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class FileBinaryMimeTypeGuesser implements MimeTypeGuesserInterface
{
    /**
     * @var string
     */
    private $cmd;
    /**
     * @param string $cmd
     */
    public function __construct($cmd = 'file -b --mime %s 2>/dev/null')
    {
        $this->cmd = $cmd;
    }
    /**
     * @return bool
     */
    public static function isSupported()
    {
        return !defined('PHP_WINDOWS_VERSION_BUILD') && function_exists('passthru') && function_exists('escapeshellarg');
    }
    /**
     * {@inheritdoc}
     */
    public function guess($path)
    {
        if (!is_file($path)) {
            throw new FileNotFoundException($path);
        }
        if (!is_readable($path)) {
            throw new AccessDeniedException($path);
        }
        if (!self::isSupported()) {
            return;
        }
        ob_start();
        // need to use --mime instead of -i. see #6641
        passthru(sprintf($this->cmd, escapeshellarg($path)), $return);
        if ($return > 0) {
            ob_end_clean();
            return;
        }
        $type = trim(ob_get_clean());
        if (!preg_match('#^([a-z0-9\-]+/[a-z0-9\-\.]+)#i', $type, $match)) {
            // it's not a type, but an error message
            return;
        }
        return $match[1];
    }
}