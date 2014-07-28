<?php

// Make everything relative to the application root
chdir(dirname(__DIR__));

// Get generator dir
$generatorDir = 'public/media/generator';

// Get current time
$ctime = new \DateTime();

foreach (scandir($generatorDir) as $file) {
    // Skip directory
    if ($file == '.' || $file == '..') {
        continue;
    }
    
    // Get filename
    $filename = sprintf("%s/%s", $generatorDir, $file);
    
    // Get last modified time
    $mtime = new \DateTime();
    $mtime->setTimestamp(filemtime($filename));
    
    $diff  = $mtime->diff(new \DateTime());
    
    if (6 <= $diff->h) {
        // Delete file
        unlink($filename);
    }
}