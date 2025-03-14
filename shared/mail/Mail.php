<?php

namespace shared\mail;

use InvalidArgumentException;

/**
 * Class Mail
 *
 * Represents user-submitted mail data and provides JSON serialization/deserialization.
 */
class Mail
{
  /** @var string|null User's name */
    private ?string $userName = null;

  /** @var string|null User's email */
    private ?string $userEmail = null;

  /** @var string|null User's phone number */
    private ?string $userPhone = null;

  /** @var string|null User's message */
    private ?string $userMessage = null;

  /** Constants for field names */
    public const NAME = "userName";
    public const EMAIL = "userEmail";
    public const PHONE = "userPhone";
    public const MSG = "userMessage";

  /**
   * Mail constructor.
   */
    public function __construct()
    {
    }

  /**
   * Gets the user's name.
   *
   * @return string|null
   */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

  /**
   * Gets the user's email.
   *
   * @return string|null
   */
    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

  /**
   * Gets the user's phone number.
   *
   * @return string|null
   */
    public function getUserPhone(): ?string
    {
        return $this->userPhone;
    }

  /**
   * Gets the user's message.
   *
   * @return string|null
   */
    public function getUserMessage(): ?string
    {
        return $this->userMessage;
    }

  /**
   * Creates a Mail object from a JSON string.
   *
   * @param string $jsonString JSON-encoded string containing user data.
   * @return self
   * @throws InvalidArgumentException
   */
    public static function fromJson(string $jsonString): self
    {
        $data = json_decode($jsonString, true);

        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid JSON provided.");
        }

        $model = new self();

        $model->userName = isset($data[self::NAME]) ? strip_tags(trim($data[self::NAME])) : null;
        $model->userName = str_replace(["\r", "\n"], " ", $model->userName);

        $model->userEmail = isset($data[self::EMAIL])
        ? filter_var(trim($data[self::EMAIL]), FILTER_SANITIZE_EMAIL)
        : null;

        $model->userPhone = isset($data[self::PHONE]) ? strip_tags(trim($data[self::PHONE])) : null;

        $model->userMessage = isset($data[self::MSG])
        ? str_replace("&#13;", "<br />", trim(nl2br(strip_tags($data[self::MSG]))))
        : null;

        return $model;
    }

  /**
   * Converts the Mail object to an associative array.
   *
   * @return array<string, string> The mail data as an array.
   */
    public function toArray(): array
    {
        return [
        self::NAME => $this->userName,
        self::EMAIL => $this->userEmail,
        self::PHONE => $this->userPhone,
        self::MSG => $this->userMessage,
        ];
    }
}
