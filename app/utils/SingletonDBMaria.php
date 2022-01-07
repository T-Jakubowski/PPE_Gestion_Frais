<?php
namespace app\utils;

class SingletonDBMaria{
    public $cnx;
    /** @var SingletonDBMaria */
    private static $instance;
    private $dsn;
    private $username;
    private $password;
    private function __construct()
    {
        $this->dsn=SingletonConfigReader::getInstance()->getValue("dsn");
        $this->username=SingletonConfigReader::getInstance()->getValue("username");
        $this->password=SingletonConfigReader::getInstance()->getValue("password");

        $this->cnx= new \PDO($this->dsn,$this->username,$this->password);
        $this->cnx->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }
    public static function getInstance() : SingletonDBMaria {
        if(is_null(self::$instance)){
            self::$instance = new SingletonDBMaria();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this->cnx;
    }
}
?>