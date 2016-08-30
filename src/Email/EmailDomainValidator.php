<?php

namespace Drupal\testmodule\Email;

/**
 * Class EmailDomainValidator
 *
 * @package Drupal\testmodule\Email
 */
class EmailDomainValidator
{
  const EMAIL_REGEXPR = "^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$";

  /**
   * @var EmailParserInterface
   */
  private $parser;

  /**
   * EmailValidator constructor.
   *
   * @param \Drupal\testmodule\Email\EmailParserInterface $parser
   */
  public function __construct(EmailParserInterface $parser) {
    $this->parser = $parser;
  }

  /**
   * @param string $email
   * @param array  $predefinedDomains
   *
   * @return bool
   * @throws \Drupal\testmodule\Email\EmailDomainException
   */
  public function validate($email, array $predefinedDomains) {
    $emailEntity = $this->parser->parse($email);

    if(!$this->isValidEmail($email)) {
      throw new EmailDomainException('Invalid email');
    }
    
    return in_array($emailEntity->getDomain(), $predefinedDomains);
  }

  /**
   * Validates email.
   *
   * @param string $email
   *
   * @return int
   */
  protected function isValidEmail($email){
    return preg_match("|" . self::EMAIL_REGEXPR . "|", $email);
  }
}
