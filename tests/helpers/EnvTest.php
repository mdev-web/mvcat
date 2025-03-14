<?php

namespace tests\helpers;

use PHPUnit\Framework\TestCase;
use shared\helpers\Env;
use Exception;

class EnvTest extends TestCase
{
    public function testEnv(): void
    {
        try {
            echo getcwd() . "/tests/assets";
            Env::load(getcwd() . "/tests/assets", ".test.env");
            $this->assertTrue(isset($_ENV['KEY']));
            $this->assertEquals("VALUE", $_ENV['KEY']);
        } catch (Exception $e) {
            $this->fail('An exception was thrown: ' . $e->getMessage());
        }
    }
}
