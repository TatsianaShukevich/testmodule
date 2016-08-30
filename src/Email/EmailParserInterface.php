<?php

namespace Drupal\testmodule\Email;

/**
 * Interface EmailParserInterface
 *
 * @package Drupal\testmodule\Email
 */
interface EmailParserInterface
{
  /**
   * Parse email.
   *
   * @param $email
   * @return EmailEntity
   */
   public function parse($email);
}
