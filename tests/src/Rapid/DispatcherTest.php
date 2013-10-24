<?php

use \Rapid\Dispatcher;

class DispatcherText extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Rapid\Dispatcher
     */
    private $disp;

    public function setUp()
    {
        $request = $this->getMockBuilder('Rapid\Request')->getMock();
        $request->expects($this->any())
            ->method('controller')
            ->will($this->returnValue('index'));
        $request->expects($this->any())
            ->method('action')
            ->will($this->returnValue('index'));

        $app = new \Rapid\Application(__DIR__ . '/../../../application/', 'development');
        $app->addModule('admin/');

        $this->disp = new \Rapid\Dispatcher($app, $request);

    }

    public function testCreate()
    {
        $this->assertInstanceOf('\Rapid\Dispatcher', $this->disp);
    }

    public function testRequest()
    {
        $this->assertInstanceOf('\Rapid\Request', $this->disp->request());
    }

    /**
     * @expectedException \Rapid\Dispatcher\Exception
     */
    public function testDispatch()
    {
        $this->disp->dispatch();
    }
}