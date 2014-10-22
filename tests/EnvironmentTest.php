<?php

namespace Neemzy\Environ\Tests;

use Neemzy\Environ\Environment;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Checks the environment's condition closure yields a correct boolean result
     *
     * @return void
     */
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



    /**
     * Checks running the environment executes its callback closure
     *
     * @return void
     */
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
}
