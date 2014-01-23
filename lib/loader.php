<?php
define('TIMESHEET', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('UPLOADS', '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR);

class Loader {
    protected static $paths = array(
        TIMESHEET
    );
    public static function addPath($path) {
        $path = realpath($path);
        if ($path) {
            self::$paths[] = $path;
        }
    }
    public static function load($class) {
        $classPath = $class . '.php'; 
        foreach (self::$paths as $path) {
            if (is_file($path . $classPath)) {
                require_once $path . $classPath;
                return;
            }
        }
    }
}
spl_autoload_register(array('Loader', 'load'));

?>
