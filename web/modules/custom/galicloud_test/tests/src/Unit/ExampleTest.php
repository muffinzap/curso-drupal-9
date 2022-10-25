<?php

namespace Drupal\Tests\galicloud_test\Unit;

use Drupal\galicloud_test\Unit;
use Drupal\Tests\UnitTestCase;

/**
 * Test description.
 *
 * @group galicloud_test
 */
class ExampleTest extends UnitTestCase {

//  /**
//   * {@inheritdoc}
//   */
//  protected function setUp(): void {
//    parent::setUp();
//    // @todo Mock required classes here.
//  }
//
//  /**
//   * Tests something.
//   */
//  public function testSomething() {
//    self::assertTrue(TRUE, 'This is TRUE!');
//  }

  protected $unit;

  /**
   * Before a test method is run, setUp() is invoked.
   * Create new unit object.
   */
  public function setUp() {
    $this->unit = new Unit();
  }

  /**
   * @covers Drupal\galicloud_test\Unit::setLength
   */
  public function testSetLength() {

    $this->assertEquals(0, $this->unit->getLength());
    $this->unit->setLength(9);
    $this->assertEquals(9, $this->unit->getLength());
  }

  /**
   * @covers Drupal\galicloud_test\Unit::getLength
   */
  public function testGetLength() {

    $this->unit->setLength(9);
    $this->assertNotEquals(10, $this->unit->getLength());
  }

  /**
   * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
   * Unset the $unit object.
   */
  public function tearDown() {
    unset($this->unit);
  }

}
