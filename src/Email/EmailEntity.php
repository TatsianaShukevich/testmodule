<?php

namespace Drupal\testmodule\Email;

/**
 * Class EmailEntity
 *
 * @package Drupal\testmodule\Email
 */
class EmailEntity
{
   /**
    * @var string
    */
   private $user;

   /**
    * @var string
    */
   private $domain;

   /**
    * EmailEntity constructor.
    *
    * @param $user
    * @param $domain
    */
   public function __construct($user, $domain) {
      $this->user = $user;
      $this->domain = $domain;
   }

   /**
    * @return mixed
    */
   public function getUser() {
      return $this->user;
   }

   /**
    * @param mixed $user
    */
   public function setUser($user) {
      $this->user = $user;
   }

   /**
    * @return mixed
    */
   public function getDomain() {
      return $this->domain;
   }

   /**
    * @param mixed $domain
    */
   public function setDomain($domain) {
      $this->domain = $domain;
   }
}
