<?php

namespace tests\helpers;

use PHPUnit\Framework\TestCase;
use shared\exceptions\EnvLoadingException;
use shared\helpers\Env;
use Exception;

class EnvTest extends TestCase
{
  /**
   * @throws EnvLoadingException
   */
    public function testEnvHappy(): void
    {
        Env::load(getcwd() . "/tests/assets", ".test.env");
        $this->assertTrue(isset($_ENV['KEY']));
        $this->assertEquals("VALUE", $_ENV['KEY']);
    }

    public function testEnvExcepted(): void
    {
        $this->expectException(EnvLoadingException::class);
        Env::load(getcwd() . "/tests/assets", ".not.existing.env");
    }
}
