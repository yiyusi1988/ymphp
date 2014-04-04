<?php

/**
 * 系统初始话配置静态类
 * yimiao@2014-03-05
 */
class Core_Init {

    private static $_uriInfo;

    public static function loadClass($class, $dirs = null) {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }

        if ((null !== $dirs) && !is_string($dirs) && !is_array($dirs)) {
            require_once 'Core/Exception.php';
            throw new Core_Exception('Directory argument must be a string or an array');
        }

        // Autodiscover the path from the class name
        // Implementation is PHP namespace-aware, and based on
        // Framework Interop Group reference implementation:
        // http://groups.google.com/group/php-standards/web/psr-0-final-proposal
        $className = ltrim($class, '\\');
        $file = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (!empty($dirs)) {
            // use the autodiscovered path
            $dirPath = dirname($file);
            if (is_string($dirs)) {
                $dirs = explode(PATH_SEPARATOR, $dirs);
            }
            foreach ($dirs as $key => $dir) {
                if ($dir == '.') {
                    $dirs[$key] = $dirPath;
                } else {
                    $dir = rtrim($dir, '\\/');
                    $dirs[$key] = $dir . DIRECTORY_SEPARATOR . $dirPath;
                }
            }
            $file = basename($file);
            self::loadFile($file, $dirs, true);
        } else {
            self::loadFile($file, null, true);
        }

        if (!class_exists($class, false) && !interface_exists($class, false)) {
            require_once 'Core/Exception.php';
            throw new Core_Exception("File \"$file\" does not exist or class \"$class\" was not found in the file");
        }
    }

    public static function loadFile($filename, $dirs = null, $once = false) {
        self::_securityCheck($filename);

        /**
         * Search in provided directories, as well as include_path
         */
        $incPath = false;
        if (!empty($dirs) && (is_array($dirs) || is_string($dirs))) {
            if (is_array($dirs)) {
                $dirs = implode(PATH_SEPARATOR, $dirs);
            }
            $incPath = get_include_path();
            set_include_path($dirs . PATH_SEPARATOR . $incPath);
        }

        /**
         * Try finding for the plain filename in the include_path.
         */
        if ($once) {
            include_once $filename;
        } else {
            include $filename;
        }

        /**
         * If searching in directories, reset include_path
         */
        if ($incPath) {
            set_include_path($incPath);
        }

        return true;
    }

    /**
     * Returns TRUE if the $filename is readable, or FALSE otherwise.
     * This function uses the PHP include_path, where PHP's is_readable()
     * does not.
     *
     * Note from ZF-2900:
     * If you use custom error handler, please check whether return value
     *  from error_reporting() is zero or not.
     * At mark of fopen() can not suppress warning if the handler is used.
     *
     * @param string   $filename
     * @return boolean
     */
    public static function isReadable($filename) {
        if (is_readable($filename)) {
            // Return early if the filename is readable without needing the
            // include_path
            return true;
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' && preg_match('/^[a-z]:/i', $filename)
        ) {
            // If on windows, and path provided is clearly an absolute path,
            // return false immediately
            return false;
        }

        foreach (self::explodeIncludePath() as $path) {
            if ($path == '.') {
                if (is_readable($filename)) {
                    return true;
                }
                continue;
            }
            $file = $path . '/' . $filename;
            if (is_readable($file)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Explode an include path into an array
     *
     * If no path provided, uses current include_path. Works around issues that
     * occur when the path includes stream schemas.
     *
     * @param  string|null $path
     * @return array
     */
    public static function explodeIncludePath($path = null) {
        if (null === $path) {
            $path = get_include_path();
        }

        if (PATH_SEPARATOR == ':') {
            // On *nix systems, include_paths which include paths with a stream
            // schema cannot be safely explode'd, so we have to be a bit more
            // intelligent in the approach.
            $paths = preg_split('#:(?!//)#', $path);
        } else {
            $paths = explode(PATH_SEPARATOR, $path);
        }
        return $paths;
    }

    /**
     * Ensure that filename does not contain exploits
     *
     * @param  string $filename
     * @return void
     * @throws Core_Exception
     */
    protected static function _securityCheck($filename) {
        /**
         * Security check
         */
        if (preg_match('/[^a-z0-9\\/\\\\_.:-]/i', $filename)) {
            require_once 'Core/Exception.php';
            throw new Core_Exception('Security check: Illegal character in filename');
        }
    }

    public static function getConf($conf) {
        $name = ucfirst($conf);
        if (!$GLOBALS[$name]) {
            $className = ltrim($conf, '\\');
            $file = '../';
            $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
            $GLOBALS[$name] = include $file;
        }
        return $GLOBALS[$name];
    }

    private static function getUriInfo() {
        $siteConf = self::getConf('Conf_Site');
        if ($siteConf['isHtml'] == 1) {
            $request_uri = substr(str_replace('.' . $siteConf['suffix'], '', $_SERVER['REQUEST_URI']), 1);
            $uriArr = explode('/', $request_uri);
            $m = $uriArr[0] ? $uriArr[0] : 'default';
            $c = $uriArr[1] ? $uriArr[1] : 'index';
            $a = $uriArr[2] ? $uriArr[2] : 'index';
        } else {
            $m = $_GET['_m'] ? $_GET['_m'] : 'default';
            $c = $_GET['_c'] ? $_GET['_c'] : 'index';
            $a = $_GET['_a'] ? $_GET['_a'] : 'index';
        }
        self::$_uriInfo = array('m' => ucfirst($m), 'c' => ucfirst($c), 'a' => ucfirst($a));
        return self::$_uriInfo;
    }

    public static function getMainName() {
        return self::$_uriInfo['m'];
    }

    public static function getControllerName() {
        return self::$_uriInfo['c'];
    }

    public static function getActionName() {
        return self::$_uriInfo['a'];
    }

    public static function run() {
        $uriInfo = self::getUriInfo();
        $m = $uriInfo['m'];
        $c = $uriInfo['c'];
        $a = $uriInfo['a'];
        $class = $m . '_' . $c . '_Controllers';
        $obj = new $class;
        $obj->_m = ucfirst($m);
        $obj->_c = ucfirst($c);
        $obj->_a = $a;
        $obj->$a();
        $obj->display();
    }

    public static function seturl($params) {
        $siteConf = self::getConf('Conf_Site');
        $otherUrl = '';
        foreach ($params as $key => $value) {
            if ($key == '_m' || $key == '_c' || $key == '_a') {
                continue;
            }
            if ($siteConf['isHtml'] === 1) {
                $otherUrl.='/' . $key . '/' . $value;
            } else {
                $otherUrl.='&' . $key . '=' . $value;
            }
        }
        $mainUrl = $siteConf['liveSite'];
        if ($otherUrl != '') {
            if ($siteConf['isHtml'] === 1) {
                $mainUrl.=$params['_m'] ? '/' . $params['_m'] : '/default';
                $mainUrl.=$params['_c'] ? '/' . $params['_c'] : '/index';
                $mainUrl.=$params['_a'] ? '/' . $params['_a'] : '/index';
            } else {
                $mainUrl.=$params['_m'] ? '/?_m=' . $params['_m'] : '/?_m=default';
                $mainUrl.=$params['_c'] ? '&_c=' . $params['_c'] : '&_c=index';
                $mainUrl.=$params['_a'] ? '&_a=' . $params['_a'] : '&_a=index';
            }
        } else {
            if ($siteConf['isHtml'] === 1) {
                $mainUrl.=$params['_m'] ? '/' . $params['_m'] : '';
                $mainUrl.=$params['_c'] ? '/' . $params['_c'] : '';
                $mainUrl.=$params['_a'] ? '/' . $params['_a'] : '';
            } else {
                $mainUrl.=$params['_m'] ? '/?_m=' . $params['_m'] : '';
                $mainUrl.=$params['_c'] ? '&_c=' . $params['_c'] : '';
                $mainUrl.=$params['_a'] ? '&_a=' . $params['_a'] : '';
            }
        }
        if ($siteConf['isHtml'] === 1) {
            $url = $mainUrl . $otherUrl; // . '.' . $siteConf['suffix'];
            $url = $url == $siteConf['liveSite'] ? $url : $url . '.' . $siteConf['suffix'];
        } else {
            $url = $mainUrl . $otherUrl;
        }
        return $url;
    }

}
