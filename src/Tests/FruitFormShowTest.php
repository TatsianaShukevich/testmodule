<?php
/**
 * @file
 * Contains \Drupal\testmodule\Tests\FruitFormShowTest.
 */

namespace Drupal\testmodule\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Functional test for Fruit form.
 * @group testmodule
 */
class FruitFormShowTest extends WebTestBase {

  /**
   * Modules to install.
   * @var array
   */
  public static $modules = ['node', 'testmodule'];

  /**
   * Tests page with Fruit form.
   */
    function testDrupalGet() {
    $this->drupalGet('testmodule/form');
    $this->assertResponse(200, 'The response of testmodule/form page is 200');

    //test form has submit button
    $this->assertField('op', 'The submit button is present.');

    //test form has email Field
    $this->assertField('email_address', 'The email field is present.');
  }

  /**
   * Test the submission of the form with wrong email.
   * @throws \Exception
   */
  public function testFruitFormSubmitWithWrongEmail() {

    $this->drupalPostForm(
      'testmodule/form',
      array(
        'favorite_fruit' => 'Grapes',
        'email_address' => 'test@test'
      ),
      t('Submit!')
    );

    $this->assertText('Email address is invalid.');

    $this->drupalPostForm(
      'testmodule/form',
      array(
        'favorite_fruit' => 'Grapes',
        'email_address' => 'test@epam.com'
      ),
      t('Submit!')
    );

    $this->assertText('Sorry, we only accept Gmail or Yahoo email addresses at this time.');
  }

  /**
   * Test the submission of the form with right email.
   * @throws \Exception
   */
  public function testFruitFormSubmitWithRightEmail() {

    $this->drupalPostForm(
      'testmodule/form',
      array(
        'favorite_fruit' => 'Grapes',
        'email_address' => 'test@gmail.com'
      ),
      t('Submit!')
    );

    $this->assertNoText('Sorry, we only accept Gmail or Yahoo email addresses at this time.');

    $this->drupalPostForm(
      'testmodule/form',
      array(
        'favorite_fruit' => 'Grapes',
        'email_address' => 'test@yahoo.com'
      ),
      t('Submit!')
    );

    $this->assertNoText('Sorry, we only accept Gmail or Yahoo email addresses at this time.');

    $this->drupalPostForm(
      'testmodule/form',
      array(
        'favorite_fruit' => 'Grapes',
        'email_address' => 'test@gmail.com'
      ),
      t('Submit!')
    );

    $this->assertText('Grapes! Wow! Nice choice! Thanks for telling us!', 'Submit with right email works.');
  }
}