<?php

namespace App\Utils;

class Validator
{
    public static function validade(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                throw new \Exception('Field ' . $field . ' is required');
            }
        }
        return $fields; 
    }
}
