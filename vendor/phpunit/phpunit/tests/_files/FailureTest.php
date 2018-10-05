<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

class FailureTest extends TestCase
{
    public function testAssertArrayEqualsArray(): void
    {
        $this->assertEquals([1], [2], 'messages');
    }

    public function testAssertIntegerEqualsInteger(): void
    {
        $this->assertEquals(1, 2, 'messages');
    }

    public function testAssertObjectEqualsObject(): void
    {
        $a      = new stdClass;
        $a->foo = 'bar';

        $b      = new stdClass;
        $b->bar = 'foo';

        $this->assertEquals($a, $b, 'messages');
    }

    public function testAssertNullEqualsString(): void
    {
        $this->assertEquals(null, 'bar', 'messages');
    }

    public function testAssertStringEqualsString(): void
    {
        $this->assertEquals('foo', 'bar', 'messages');
    }

    public function testAssertTextEqualsText(): void
    {
        $this->assertEquals("foo\nbar\n", "foo\nbaz\n", 'messages');
    }

    public function testAssertStringMatchesFormat(): void
    {
        $this->assertStringMatchesFormat('*%s*', '**', 'messages');
    }

    public function testAssertNumericEqualsNumeric(): void
    {
        $this->assertEquals(1, 2, 'messages');
    }

    public function testAssertTextSameText(): void
    {
        $this->assertSame('foo', 'bar', 'messages');
    }

    public function testAssertObjectSameObject(): void
    {
        $this->assertSame(new stdClass, new stdClass, 'messages');
    }

    public function testAssertObjectSameNull(): void
    {
        $this->assertSame(new stdClass, null, 'messages');
    }

    public function testAssertFloatSameFloat(): void
    {
        $this->assertSame(1.0, 1.5, 'messages');
    }

    // Note that due to the implementation of this assertion it counts as 2 asserts
    public function testAssertStringMatchesFormatFile(): void
    {
        $this->assertStringMatchesFormatFile(__DIR__ . '/expectedFileFormat.txt', '...BAR...');
    }
}
