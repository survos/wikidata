<?php
// @todo:move to namespace, etc.  NOT global!

/**
 * Check if given string is valid Wikidata entity ID
 *
 * @param string $value
 *
 * @return bool Return true if string is valid or false
 */
if (!function_exists('is_qid')) {
    function is_qid($value): int|false
    {
        return preg_match("/^Q[0-9]+/", (string) $value);
    }
}

/**
 * Check if given string is valid Wikidata property ID
 *
 * @param string $value
 *
 * @return bool Return true if string is valid or false
 */
if (!function_exists('is_pid')) {
    function is_pid($value): int|false
    {
        return preg_match("/^P[0-9]+/", (string) $value);
    }
}

/**
 * Get ID from URL
 *
 * @param string $string String from which to get the ID
 *
 * @return string
 */
if (!function_exists('get_id')) {

    function get_id($string)
    {
        preg_match('/(Q|P)\d+/i', (string) $string, $matches);

        return !empty($matches) ? $matches[0] : $string;
    }
}
