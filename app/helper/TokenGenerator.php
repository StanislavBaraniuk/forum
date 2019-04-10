<?php

/**
 * Class TokenGenerator
 */
class TokenGenerator
{
    /**
     * @return string
     */
    public static function generate ($len = 30) : string {
        $token = '';

        for ($i = 0; $i < $len; $i++) {
            $symbol = [rand(48, 57), rand(97, 122), rand(65, 90)];

            $token .= chr($symbol[rand(0, 2)]);
        }

        return $token;
    }
}