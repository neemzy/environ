<?php

namespace Neemzy\Environ\Tests;

use Neemzy\Environ\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Manager
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
     * @param Manager
     *
     * @depends           testAdd
     * @expectedException Neemzy\Environ\Exception\UndefinedEnvironmentException
     */
    public function testSetWithInvalidName($manager)
    {
        $manager->set('invalid');
    }

    /**
     * @param Manager
     *
     * @return Manager
     *
     * @depends testAdd
     */
    public function testSetWithValidName($manager)
    {
        $manager->set('test');

        return $manager;
    }

    /**
     * @param Manager
     *
     * @depends testSetWithValidName
     */
    public function testGet($manager)
    {
        $this->assertEquals('test', $manager->get());
    }

    /**
     * @param Manager
     *
     * @depends testSetWithValidName
     */
    public function testIs($manager)
    {
        $this->assertTrue($manager->is('test'));
        $this->assertFalse($manager->is('something'));
    }

    /**
     * @expectedException Neemzy\Environ\Exception\NoApplicableEnvironmentException
     */
    public function testInitWithoutEligibleEnvironment()
    {
        $manager = new Manager();
        $manager->init();
    }

    /**
     * @param Manager
     *
     * @depends testSetWithValidName
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
