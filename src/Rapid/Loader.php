<?php

/**
 * @author Dmitry Merkushin <merkushin@gmail.com>
 */
namespace Rapid;

/**
 * Class Loader.
 *
 * Original parts from zf2 standard autoloader
 */
class Loader
{
    const NAMESPACE_SEPARATOR = '\\';
    const PREFIX_SEPARATOR = '/';

    protected $namespaces = array();

    public function registerNamespace($namespace, $path)
    {
        $namespace = rtrim($namespace, self::NAMESPACE_SEPARATOR).self::NAMESPACE_SEPARATOR;
        $this->namespaces[$namespace] = $this->normalizePath($path);

        return $this;
    }

    /**
     * Defined by Autoloadable; autoload a class.
     *
     * @param string $class
     *
     * @return bool|string
     */
    public function autoload($class)
    {
        if (false !== strpos($class, self::NAMESPACE_SEPARATOR)) {
            if ($this->loadClass($class)) {
                return $class;
            }

            return false;
        }

        return false;
    }

    /**
     * Register the autoloader with spl_autoload.
     */
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Load class.
     *
     * @param string $class
     *
     * @return bool|mixed
     */
    protected function loadClass($class)
    {
        //var_dump($this->namespaces); exit;
        foreach ($this->namespaces as $leader => $path) {
            if (0 === strpos($class, $leader)) {
                // Trim off leader (namespace or prefix)
                $trimmedClass = substr($class, strlen($leader));

                // create filename
                $filename = $this->transformClassNameToFilename($trimmedClass, $path);
                if (file_exists($filename)) {
                    return include $filename;
                }

                return false;
            }
        }

        return false;
    }

    /**
     * Transform the class name to a filename.
     *
     * @param string $class
     * @param string $directory
     *
     * @return string
     */
    protected function transformClassNameToFilename($class, $directory)
    {
        // $class may contain a namespace portion, in  which case we need
        // to preserve any underscores in that portion.
        $matches = array();
        preg_match('/(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $class, $matches);

        $class = (isset($matches['class'])) ? $matches['class'] : '';
        $namespace = (isset($matches['namespace'])) ? $matches['namespace'] : '';

        return $directory
            .str_replace(self::NAMESPACE_SEPARATOR, '/', $namespace)
            .str_replace(self::PREFIX_SEPARATOR, '/', $class)
            .'.php';
    }

    protected function normalizePath($path)
    {
        $last = $path[strlen($path) - 1];
        if (in_array($last, array('/', '\\'))) {
            $path[strlen($path) - 1] = DIRECTORY_SEPARATOR;

            return $path;
        }
        $path .= DIRECTORY_SEPARATOR;

        return $path;
    }
}
