<?php


namespace LaraRsa;


class LaraRsa
{

    public function __call($name, $arguments)
    {
        return self::params($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::params($name, $arguments);
    }


    private static function params($name, $arguments){
        $RsaKey = RsaKey::getIns();
        return $RsaKey ->$name(...$arguments);
    }
}