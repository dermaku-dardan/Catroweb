<?php

namespace Tests\PhpUnit\Utils;

use App\Utils\ElapsedTimeStringFormatter;
use App\Utils\TimeUtils;
use DateTime;
use Exception;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers  \App\Utils\ElapsedTimeStringFormatter
 */
class ElapsedTimeStringFormatterTest extends TestCase
{
  protected int $test_time;

  private ElapsedTimeStringFormatter|MockObject $object;

  /**
   * @throws Exception
   */
  protected function setUp(): void
  {
    $this->object = $this->getMockBuilder(ElapsedTimeStringFormatter::class)
      ->disableOriginalConstructor()
      ->onlyMethods([
        'getFormattedInMinutes',
        'getFormattedInHours',
        'getFormattedInDays',
        'getFormattedInMonths',
        'getFormattedInYears',
      ])
      ->getMock()
    ;
  }

  public function testInitialization(): void
  {
    $this->assertInstanceOf(ElapsedTimeStringFormatter::class, $this->object);
  }

  /**
   * @group unit
   *
   * @small
   *
   * @covers \App\Utils\ElapsedTimeStringFormatter::format
   *
   * @dataProvider dataProviderElapsedTimeStringFormatter
   *
   * @throws Exception
   */
  public function testElapsedTimeStringFormatter(string $expected, int $timestamp): void
  {
    $this->object->expects(self::once())->method($this->getExpectedFormatterMethod($expected));
    $this->object->format($timestamp);
  }

  protected function getExpectedFormatterMethod(string $expected): string
  {
    return match ($expected) {
      'minutes' => 'getFormattedInMinutes',
      'hours' => 'getFormattedInHours',
      'days' => 'getFormattedInDays',
      'months' => 'getFormattedInMonths',
      'years' => 'getFormattedInYears',
      default => '',
    };
  }

  /**
   * @throws Exception
   */
  public function dataProviderElapsedTimeStringFormatter(): Generator
  {
    TimeUtils::freezeTime(new DateTime('2015-10-26 13:33:37'));
    $this->test_time = TimeUtils::getTimestamp();
    yield ['minutes', $this->test_time + 1];
    yield ['minutes', $this->test_time];
    yield ['minutes', $this->test_time - 1];
    yield ['minutes', $this->test_time - 1000];
    yield ['minutes', $this->test_time - 3_540];
    yield ['hours', $this->test_time - 3_541];
    yield ['hours', $this->test_time - 3_600 * 5];
    yield ['hours', $this->test_time - 3_600 * 5 - 10];
    yield ['hours', $this->test_time - 3_600 * 23];
    yield ['days', $this->test_time - 3_600 * 24];
    yield ['days', $this->test_time - 82_801];
    yield ['days', $this->test_time - 86_400 * 5];
    yield ['days', $this->test_time - 86_400 * 5 - 10];
    yield ['days', $this->test_time - 86_400 * 6];
    yield ['months', $this->test_time - 86_400 * 31];
    yield ['months', $this->test_time - 2_505_601];
    yield ['months', $this->test_time - 2_629_800 * 6];
    yield ['months', $this->test_time - 2_629_800 * 6 - 10];
    yield ['months', $this->test_time - 2_629_800 * 11];
    yield ['years', $this->test_time - 2_629_800 * 12];
    yield ['years', $this->test_time - 31_557_600];
    yield ['years', $this->test_time - 31_557_600 * 3];
    yield ['years', $this->test_time - 31_557_600 * 3 - 10];
    yield ['years', $this->test_time - 31_557_600 * 100];
  }
}
