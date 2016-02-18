<?php

namespace Neemzy\Environ\Tests;

use Neemzy\Environ\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Checks adding an environment to the manager
     *
     * @return \Neemzy\Environ\Manager Manager instance
     */
    public function testAdd()
    {
        $manager = new Manager();

        $environment = $this->getMock('Neemzy\Environ\Environment', ['test', 'run'], [], '', false);
        $manager->add('test', $environment);

        $reflection = new \ReflectionClass('Neemzy\Environ\Manager');
        $environments = $reflection->getProperty('environments');
        $environments->setAccessible(true);

        $this->assertSame($environment, $environments->getValue($manager)['test']);

        return $manager;
    }



    /**
     * Checks setting the current environment by an invalid name
     *
     * @depends testAdd
     * @param \Neemzy\Environ\Manager Manager instance
     *
     * @expectedException \Neemzy\Environ\Exception\UndefinedEnvironmentException
     * @return void
     */
    public function testSetWithInvalidName($manager)
    {
        $manager->set('invalid');
    }



    /**
     * Checks setting the current environment by a valid name
     *
     * @depends testAdd
     * @param \Neemzy\Environ\Manager Manager instance
     *
     * @return \Neemzy\Environ\Manager Manager instance
     */
    public function testSetWithValidName($manager)
    {
        $manager->set('test');

        return $manager;
    }



    /**
     * Checks getting the current environment's name
     *
     * @depends testSetWithValidName
     * @param \Neemzy\Environ\Manager Manager instance crafted in previous test
     *
     * @return void
     */
    public function testGet($manager)
    {
        $this->assertEquals('test', $manager->get());
    }



    /**
     * Checks testing the current environment by name
     *
     * @depends testSetWithValidName
     * @param \Neemzy\Environ\Manager Manager instance crafted in previous test
     *
     * @return void
     */
    public function testIs($manager)
    {
        $this->assertTrue($manager->is('test'));
        $this->assertFalse($manager->is('something'));
    }



    /**
     * Checks initializing the manager to auto-select the environment without an eligible one
     *
     * @expectedException \Neemzy\Environ\Exception\NoApplicableEnvironmentException
     * @return void
     */
    public function testInitWithoutEligibleEnvironment()
    {
        $manager = new Manager();
        $manager->init();
    }



    /**
     * Checks initializing the manager to auto-select the environment with an eligible one
     *
     * @depends testSetWithValidName
     * @param \Neemzy\Environ\Manager Manager instance crafted in previous test
     *
     * @return void
     */
    public function testInitWithEligibleEnvironment($manager)
    {
        $environment = $this->getMock('Neemzy\Environ\Environment', ['test', 'run'], [], '', false);
        $environment->expects($this->once())->method('test')->will($this->returnValue(true));

        $manager->add('new', $environment);
        $manager->init();

        $this->assertEquals('new', $manager->get());
    }
}
