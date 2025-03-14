<?php

namespace shared\helpers;

use Dotenv\Dotenv;
use Exception;

class Env
{
  private function __construct()
  {
  }

  /**
   * @param string $envPath folder with ENV file
   * @param string $envFile the name of ENV file
   * @throws Exception
   */
  public static function load(string $envPath, string $envFile): void
  {
    try {
      Dotenv::createMutable($envPath, $envFile)->load();
    } catch (Exception $e) {
      throw new Exception(
        sprintf("An error occurred while loading the environment file '%s'.", $envFile),
        500,
        $e
      );
    }
  }
}
