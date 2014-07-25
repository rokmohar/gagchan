<?php

namespace Core\Utils;

/**
 * @auhtor Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class TokenGenerator
{
    /**
     * @var \Core\Utils\TokenGenerator
     */
    private static $instance;
    
    /**
     * @param int $min
     * @param int $max
     * 
     * @return mixed
     */
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        
        if ($range < 0) {
            // not so random...
            return $min;
        }
        
        $log    = log($range, 2);
        $bytes  = (int) ($log / 8) + 1;
        $bits   = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        }
        while ($rnd >= $range);
        
        return $min + $rnd;
    }

    /**
     * @param int $length
     * 
     * @return string
     */
    function getToken($length)
    {
        $token = "";
        
        $codeAlphabet  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        
        for($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        
        return $token;
    }
    
    /**
     * @return \Core\Utils\TokenGenerator
     */
    public static function getInstance()
    {
        // Check if instance is empty
        if (self::$instance === null) {
            // Create an instance
            self::$instance = new self();
        }
        
        return self::$instance;
    }
}
