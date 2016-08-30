<?php

namespace Drupal\testmodule\Email;

/**
 * Class EmailParser
 *
 * @package Drupal\testmodule\Email
 */
class EmailParser implements EmailParserInterface
{
  /**
   * @inheritdoc 
   */
   public function parse($email){
      $url = explode('@', $email);

      return new EmailEntity($url[0], $url[1]);
   }
}
