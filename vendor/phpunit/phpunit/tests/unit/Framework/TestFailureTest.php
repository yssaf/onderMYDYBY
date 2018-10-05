<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework;

class TestFailureTest extends TestCase
{
    public function testToString(): void
    {
        $test      = new self(__FUNCTION__);
        $exception = new Exception('messages');
        $failure   = new TestFailure($test, $exception);

        $this->assertEquals(__METHOD__ . ': messages', $failure->toString());
    }

    public function testToStringForError(): void
    {
        $test      = new self(__FUNCTION__);
        $exception = new \Error('messages');
        $failure   = new TestFailure($test, $exception);

        $this->assertEquals(__METHOD__ . ': messages', $failure->toString());
    }

    public function testgetExceptionAsString(): void
    {
        $test      = new self(__FUNCTION__);
        $exception = new \Error('messages');
        $failure   = new TestFailure($test, $exception);

        $this->assertEquals("Error: messages\n", $failure->getExceptionAsString());
    }
}
