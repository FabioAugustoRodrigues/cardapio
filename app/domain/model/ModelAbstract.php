<?php

namespace app\domain\model;

abstract class ModelAbstract{

    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    public abstract static function create();
    public abstract function toArray();
}