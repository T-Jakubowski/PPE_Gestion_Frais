<?php
namespace app\utils;
class SingletonConfigReader
{   
    private static $instance;

    private function __construct(){}
    public function getValue($key)
    {
        $ini_array = parse_ini_file("../app/utils/config.ini");
        foreach ($ini_array as $keys => $value){
            if ($key==$keys){
                $data=$value;
            }
    }
        return $data;
    }
    public static function getInstance() : SingletonConfigReader {
        if(is_null(self::$instance)){
            self::$instance = new SingletonConfigReader();
        }
        return self::$instance;
    }
}
?>