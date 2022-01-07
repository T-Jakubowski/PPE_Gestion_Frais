<?php

/*
 * Version 3
 */

if (!isset($INITCONTEXT)) {
    $context = new InitContext(InitContext::$NOUSECLASSEXTENSION);
    global $INITCONTEXT;
    $INITCONTEXT = true;
}

class InitContext {

    public static $USECLASSEXTENSION = 0; // 0 : old file naming usage (fake.class.ph)
    public static $NOUSECLASSEXTENSION = 1; // 1 : current naming usage (fake.php)
    private $directoriesList = array(
        "./",
        "classes/",
        "vendor/",
    );
    private $classNameType;

    /**
     * 
     */
    function __construct($type=1) {
        $this->classNameType = $type;
        spl_autoload_register(array($this, "autoloader"));
    }

    /**
     * 
     */
    function autoloader($class): bool {
        foreach ($this->directoriesList as $path) {
            if ($this->classNameType == self::$USECLASSEXTENSION) {
                $filename = __DIR__ . "/" . $path . str_replace('\\', '/', $class) . ".class.php";
            } elseif ($this->classNameType == self::$NOUSECLASSEXTENSION) {
                $filename = __DIR__ . "/" . $path . str_replace('\\', '/', $class) . ".php";
            }
            if (file_exists($filename) && is_readable($filename)) {
                require $filename;
                if (class_exists($class)) {
                    return TRUE;
                }
            }
        }
        return false;
    }

}

?>