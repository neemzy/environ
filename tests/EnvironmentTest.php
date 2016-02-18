<?php

namespace Neemzy\Environ\Tests;

use Neemzy\Environ\Environment;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    public function testTest()
    {
        $truthyEnvironment = new Environment(
            function () {
                return 'truthy';
            },
            function () {
            }
        );

        $falsyEnvironment = new Environment(
            function () {
                return '';
            },
            function () {
            }
        );

        $this->assertSame(true, $truthyEnvironment->test());
        $this->assertSame(false, $falsyEnvironment->test());
    }

    public function testRun()
    {
        $flag = false;

        $environment = new Environment(
            function () {
            },
            function () use (&$flag) {
                $flag = true;
            }
        );

        $environment->run();
        $this->assertTrue($flag);
    }

    public function testRunWithNoCallback()
    {
        $environment = new Environment(
            function () {
            }
        );

        $environment->run();
        $this->assertTrue(true); // no error has been raised
    }
}
