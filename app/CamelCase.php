<?php

namespace App;

trait CamelCase
{
    /**
     * Overides the parent toArray method to return camelcased keys
     * @return array camelcased attributes
     */
    public function toArray()
    {
        $camelCaseArray = [];
        $array = parent::toArray();
        foreach ($array as $key => $value) {
            $camelCaseArray[camel_case($key)] = $value;
        }

        return $camelCaseArray;
    }
}
