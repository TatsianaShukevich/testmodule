<?php

namespace Drupal\Tests\testmodule\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\testmodule\Email\EmailDomainValidator;
use Drupal\testmodule\Email\EmailParserInterface;
use Drupal\testmodule\Email\EmailEntity;

/**
 * @coversDefaultClass  \Drupal\testmodule\Email\EmailDomainValidator
 */
class EmailDomainValidatorTest extends UnitTestCase {

  /**
   * @var \Drupal\testmodule\Email\EmailParserInterface
   */
  private $parser;

  /**
   * @var \Drupal\testmodule\Email\EmailDomainValidator
   */
  private $emailDomainValidator;

  /**
   * @inheritdoc
   */
  protected function setUp() {
    parent::setUp();

    $this->parser = $this->getMock('Drupal\testmodule\Email\EmailParserInterface');

    $this->emailDomainValidator = new EmailDomainValidator($this->parser);
    $this->assertTrue($this->parser instanceof EmailParserInterface);
  }

  /**
   * Get an accessible method using reflection.
   */
  public function getAccessibleMethod($class_name, $method_name) {
    $class = new \ReflectionClass($class_name);
    $method = $class->getMethod($method_name);
    $method->setAccessible(TRUE);
    return $method;
  }

  /**
   * The data provider for testing IsValidEmail method.
   *
   * @return array
   *   An array of valid emails to test.
   */
  public function IsValidEmailValidEmailDataProvider() {
    return [
      ['test@gmail.com'],
      ['test@yahoo.com'],
    ];
  }

  /**
   * The data provider for testing IsValidEmail method.
   *
   * @return array
   *   An array of invalid emails to test.
   */
  public function IsValidEmailInvalidEmailDataProvider() {
    return [
      ['test.epam.com'],
      ['testbk.com'],
    ];
  }

  /**
   * The data provider for testing validate method.
   *
   * @return array
   *   An array of valid emails with valid domains to test.
   */
  public function ValidateValidDomainDataProvider() {
    return [
      ['test@gmail.com', ['gmail.com', 'yahoo.com']],
      ['test@yahoo.com', ['gmail.com', 'yahoo.com']],
    ];
  }

  /**
   * The data provider for testing validate method.
   *
   * @return array
   *   An array of valid emails with invalid domains to test.
   */
  public function ValidateInvalidDomainDataProvider() {
    return [
      ['test@epam.com', ['gmail.com', 'yahoo.com']],
      ['test@test.com', ['gmail.com', 'yahoo.com']],
    ];
  }


  /**
   * Tests validate method with valid domains.
   *
   * @dataProvider ValidateValidDomainDataProvider
   *
   * @param string $email
   * @param array  $predefinedDomains
   */
  public function testValidateValidDomain($email,  $predefinedDomains) {

    $url = explode('@', $email);

    $this->parser->expects($this->any())
      ->method('parse')
      ->with($email)
      ->will($this->returnValue(new EmailEntity($url[0], $url[1])) );


    $emailEntityMock = $this->getMockBuilder('EmailEntity')
      ->setMethods(array('getDomain'))
      ->disableOriginalConstructor()
      ->setConstructorArgs(array($url[0], $url[1]))
      ->getMock();


    $emailEntityMock->expects($this->any())
      ->method('getDomain')
      ->will($this->returnValue($url[1]));


    $validEmail = $this->emailDomainValidator->validate($email, $predefinedDomains);

    $this->assertTrue($validEmail, $email . ' with valid domain');
  }

  /**
   * Tests validate method with invalid domains.
   *
   * @dataProvider ValidateInvalidDomainDataProvider
   *
   * @param string $email
   * @param array  $predefinedDomains
   */
  public function testValidateInvalidDomain($email,  $predefinedDomains) {

    $url = explode('@', $email);

    $this->parser->expects($this->any())
      ->method('parse')
      ->with($email)
      ->will($this->returnValue(new EmailEntity($url[0], $url[1])) );


    $emailEntityMock = $this->getMockBuilder('EmailEntity')
      ->setMethods(array('getDomain'))
      ->disableOriginalConstructor()
      ->setConstructorArgs(array($url[0], $url[1]))
      ->getMock();


    $emailEntityMock->expects($this->any())
      ->method('getDomain')
      ->will($this->returnValue($url[1]));


    $validEmail = $this->emailDomainValidator->validate($email, $predefinedDomains);

    $this->assertFalse($validEmail, $email . ' with invalid domain');
  }

  /**
   * Tests IsValidEmail method with valid emails.
   *
   * @dataProvider IsValidEmailValidEmailDataProvider
   *
   * @param string $email
   *
   */
  public function testIsValidEmailValidEmail($email){

    $isValidEmail = $this->getAccessibleMethod(
      'Drupal\testmodule\Email\EmailDomainValidator',
      'isValidEmail'
    );

    $validEmail = $isValidEmail->invokeArgs($this->emailDomainValidator, array($email));

    $this->assertEquals(1, $validEmail, $email . ' is valid email');


  }

  /**
   * Tests IsValidEmail method with invalid emails.
   *
   * @dataProvider IsValidEmailInvalidEmailDataProvider
   *
   * @param string $email
   */
  public function testIsValidEmailInvalidEmail($email){

    $isValidEmail = $this->getAccessibleMethod(
      'Drupal\testmodule\Email\EmailDomainValidator',
      'isValidEmail'
    );

    $invalidEmail = $isValidEmail->invokeArgs($this->emailDomainValidator, array($email));

    $this->assertEquals(0, $invalidEmail, $email . ' is invalid email');
  }
}