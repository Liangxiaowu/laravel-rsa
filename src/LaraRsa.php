<?php


namespace LaraRsa;


class LaraRsa
{

    private static $rsaKeyStatic;
    public function __construct()
    {
        self::$rsaKeyStatic = RsaKey::getIns();
    }

    public function __call($name, $arguments)
    {
        self::params($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        self::params($name, $arguments);
    }


    private static function params($name, $arguments){
        $count = count($arguments);
        switch ($count){
            case 1:
                $result = self::$rsaKeyStatic->$name($arguments[0]);
                break;
            case 2:
                $result = self::$rsaKeyStatic->$name($arguments[0],$arguments[1]);
                break;
            case 3:
                $result = self::$rsaKeyStatic->$name($arguments[0],$arguments[1],$arguments[2]);
                break;
            case 4:
                $result = self::$rsaKeyStatic->$name($arguments[0],$arguments[1],$arguments[2],$arguments[3]);
                break;
            case 5:
                $result = self::$rsaKeyStatic->$name($arguments[0],$arguments[1],$arguments[2],$arguments[3],$arguments[4]);
                break;
            default:
                $result = self::$rsaKeyStatic->$name();
                break;
        }

        return $result;
    }
}