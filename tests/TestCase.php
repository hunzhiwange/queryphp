<?php

declare(strict_types=1);

namespace Tests;

use Leevel\Kernel\Testing\Database;
use Leevel\Kernel\Testing\TestCase as TestCases;

/**
 * phpunit 基础测试类.
 *
 * @method void assertEquals(mixed $expected, mixed $actual, string $message = '');
 * @method void assertFalse(bool $condition, string $message = '');
 * @method void assertNotFalse(bool $condition, string $message = '');
 * @method void assertTrue(bool $condition, string $message = '');
 * @method void assertNull(mixed $variable, string $message = '');
 * @method void assertNotTrue(bool $condition, string $message = '');
 * @method void assertArrayHasKey(mixed $key, array $array, string $message = '');
 * @method void assertClassHasAttribute(string $attributeName, string $className, string $message = '');
 * @method void assertStringMatchesFormat(string $format, string $string, string $message = '');
 * @method void assertStringMatchesFormatFile(string $format, string $string, string $message = '');
 * @method void assertSame(mixed $expected, mixed $actual, string $message = '');
 * @method void assertStringEndsWith(string $suffix, string $string, string $message = '');
 * @method void assertStringEndsNotWith(string $suffix, string $string, string $message = '');
 * @method void assertStringStartsWith(string $prefix, string $string, string $message = '');
 * @method void assertStringStartsNotWith(string $prefix, string $string, string $message = '');
 * @method void assertStringContainsString(string $needle, string $haystack, string $message = '');
 * @method void assertStringNotContainsString(string $prefix, string $string, string $message = '');
 * @method void assertGreaterThan(mixed $expected, mixed $actual, string $message = '')
 * @method void assertGreaterThanOrEqual(mixed $expected, mixed $actual, string $message = '')
 * @method void assertAttributeGreaterThan(mixed $expected, mixed $actual, string $message = '')
 * @method void assertAttributeGreaterThanOrEqual(mixed $expected, mixed $actual, string $message = '')
 * @method void assertInstanceOf(string $expected, mixed $actual, string $message = '')
 * @method void assertNotInstanceOf(string $expected, mixed $actual, string $message = '')
 * @method void expectException(string $exception)
 * @method void expectExceptionMessage(string $message)
 */
abstract class TestCase extends TestCases
{
    use App;
    use Database;
    use Helper;
}
