<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

final class HelloWorldTest extends TestCase
{
    public function testItWorksFine(): void
    {
        $this->assertEquals('Hello World', 'Hello World');
    }
}