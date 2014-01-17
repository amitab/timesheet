<?php
define('TIMESHEET', dirname(__FILE__) . DIRECTORY_SEPARATOR);

class AutoLoader {
    protected static $paths = array(
        TIMESHEET ,
    );
    public static function addPath($path) {
        $path = realpath($path);
        if ($path) {
            self::$paths[] = $path;
        }
    }
    public static function load($class) {
        $classPath = $class . '.php'; // Do whatever logic here
        foreach (self::$paths as $path) {
            if (is_file($path . $classPath)) {
                require_once $path . $classPath;
                return;
            }
        }
    }
}
spl_autoload_register(array('AutoLoader', 'load'));

?>
