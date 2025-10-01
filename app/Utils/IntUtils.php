<?php

namespace App\Utils;

class IntUtils{

    public static function apenasInteiros(array $inteiros){
        foreach($inteiros as $int){
            if(!is_int($int)){
                return false;
            }
        }
        return true;
    }
}
