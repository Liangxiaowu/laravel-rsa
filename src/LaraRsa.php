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
        $count = count($arguments);
        switch ($count){
            case 1:
                $result = $RsaKey->$name($arguments[0]);
                break;
            case 2:
                $result = $RsaKey->$name($arguments[0],$arguments[1]);
                break;
            case 3:
                $result = $RsaKey->$name($arguments[0],$arguments[1],$arguments[2]);
                break;
            case 4:
                $result = $RsaKey->$name($arguments[0],$arguments[1],$arguments[2],$arguments[3]);
                break;
            case 5:
                $result = $RsaKey->$name($arguments[0],$arguments[1],$arguments[2],$arguments[3],$arguments[4]);
                break;
            default:
                $result = $RsaKey->$name();
                break;
        }
        return $result;
    }
}