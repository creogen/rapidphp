<?php
namespace RapidTest;

use \Rapid\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    private $loaders;
    private $includePath;

    /**
     * Backup original autoloaders
     */
    public function setUp()
    {
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            $this->loaders = array();
        }

        $this->includePath = get_include_path();
    }

    /**
     * Restore original autoloaders
     */
    public function tearDown()
    {
        $loaders = spl_autoload_functions();
        if (is_array($loaders)) {
            foreach ($loaders as $loader) {
                spl_autoload_unregister($loader);
            }
        }

        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }

        set_include_path($this->includePath);
    }

    public function testClassDoesNotExist()
    {
        $loader = new Loader();
        $loader->autoload('\Rapid\Unknown');
        $this->assertFalse(class_exists('\Rapid\Unknown', false));
    }

    public function testClassExists()
    {
        $loader = new Loader();
        $loader->autoload('\Rapid\Application');
        $this->assertTrue(class_exists('\Rapid\Application', false));
    }

}