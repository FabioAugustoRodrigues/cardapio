<?php

namespace app\util;

class JsonMapper {

    public function map($data, $context) {
        $json_mapper = function() use ($data) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key) ) {
                    $this->{$key} = $value;
                }
            }
        };

        $json_mapper = $json_mapper->bindTo($context, $context);
        $json_mapper();

        return $context;
    }
    
}