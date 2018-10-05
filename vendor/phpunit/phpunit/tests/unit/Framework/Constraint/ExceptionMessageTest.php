<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\TestCase;

class ExceptionMessageTest extends TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage A literal exception messages
     */
    public function testLiteralMessage(): void
    {
        throw new \Exception('A literal exception messages');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage A partial
     */
    public function testPartialMessageBegin(): void
    {
        throw new \Exception('A partial exception messages');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage partial exception
     */
    public function testPartialMessageMiddle(): void
    {
        throw new \Exception('A partial exception messages');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage exception messages
     */
    public function testPartialMessageEnd(): void
    {
        throw new \Exception('A partial exception messages');
    }
}
