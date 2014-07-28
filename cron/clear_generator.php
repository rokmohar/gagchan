<?php

// Make everything relative to the application root
chdir(dirname(__DIR__));

// Get generator dir
$generatorDir = 'public/media/generator';

// Get current time
$ctime = new \DateTime();

foreach (scandir($generatorDir) as $file) {
    // Get filename
    $filename = sprintf("%s/%s", $generatorDir, $file);
    
    // Skip if directory
    if (!is_file($filename)) {
        continue;
    }
    
    // Get last modified time
    $mtime = new \DateTime();
    $mtime->setTimestamp(filemtime($filename));
    
    $diff  = $mtime->diff(new \DateTime());
    
    if (1 <= $diff->h) {
        // Delete file
        unlink($filename);
    }
}