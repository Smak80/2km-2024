<?php

namespace common;

class json_loader
{
    public static function load(string $filename){
        $data = array();
        try{
            if (file_exists($filename)) {
                $data = json_decode(
                    file_get_contents($filename),
                    true
                );
            }
        } catch (\Exception $ex){

        }
        return $data;
    }
}