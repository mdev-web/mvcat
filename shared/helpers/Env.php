<?php

namespace shared\helpers;

use Dotenv\Dotenv;
use Exception;

/**
 * Class Env
 *
 * A utility class for handling environment variables using Dotenv.
 */
class Env
{
  /**
   * Private constructor to prevent instantiation.
   */
    private function __construct()
    {
    }

  /**
   * Loads environment variables from a specified file.
   *
   * @param string $envPath The directory where the ENV file is located.
   * @param string $envFile The name of the ENV file.
   *
   * @throws Exception If an error occurs while loading the environment file.
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
